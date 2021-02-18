<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $lang = get_default_lang();
        $categories = MainCategory::where('trans_lang', $lang)->select()->paginate(10);
        return view('admin.maincategories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.maincategories.create');
    }

    public function store(AddCategoryRequest $request)
    {


        if ($request->has('photo')) {
            $image = $request->photo->store('main_categories');
        }

        $main_categories = collect($request->category);
        $filter = $main_categories->filter(function ($value, $key) {
            return $value['abbr'] === get_default_lang();
        });
        $defualt_category = array_values($filter->all())[0];

        $defualt_category_id = MainCategory::insertGetId([
            'trans_lang' => $defualt_category['abbr'],
            'trans_of' => 0,
            'name' => $defualt_category['name'],
            'active' => $defualt_category['active'],
            'photo' => $image
        ]);

        $categories = $main_categories->filter(function ($value, $key) {
            return $value['abbr'] !== get_default_lang();
        });

        $categories_arr = [];

        if (isset($categories) && $categories->count() > 0) {
            foreach ($categories as $category) {
                $categories_arr[] = [
                    'trans_lang' => $category['abbr'],
                    'trans_of' => $defualt_category_id,
                    'name' => $category['name'],
                    'active' => $category['active'],
                    'photo' => $image,
                ];
            }
        }

        MainCategory::insert($categories_arr);
        return redirect()->route('admin.categories')->with('success', 'تم إضافة قسم جديد بنجاح ');
    }


    public function edit($id)
    {
        $category = MainCategory::with('languages')->find($id);
        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'حدث خطأ ما ، هذا القسم غير موجود !');
        }
        return view('admin.maincategories.edit', compact('category'));
    }

    public function update(AddCategoryRequest $request, $id)
    {
        $category = MainCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'حدث خطأ ما ، هذا القسم غير موجود !');
        }

        if ($request->has('photo')) {
            $photo = $request->photo->store('main_categories');
        } else {
            $photo = $category->photo;
        }

        if (!$request->has('category.0.active')) {
            $request->request->add(['active' => '0']);
        } else {
            $request->request->add(['active' => '1']);
        }
        $storing_category = array_values($request->category)[0];
        $category->update([
            'name' => $storing_category['name'],
            'photo' => $photo,
            'active' => $request->active,
        ]);

        return redirect()->route('admin.categories')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy($id)
    {
        $category = MainCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'حدث خطأ ما ، هذا القسم غير موجود !');
        }

        $vendors = $category->vendors;
        if (isset($vendors) && $vendors->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'لا يمكن حذف هذا القسم');
        }

        Storage::delete($category->photo);

        $category->languages()->delete();
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'تم حذف القسم بنجاح');
    }

    public function changeStatus($id)
    {
        $category = MainCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'حدث خطأ ما ، هذا القسم غير موجود !');
        }

        $status = $category->active == "1" ? "0" : "1";

        $category->update([
            'active' => $status,
        ]);

        return redirect()->route('admin.categories')->with('success', 'تم تغيير حالة القسم بنجاح');
    }
}
