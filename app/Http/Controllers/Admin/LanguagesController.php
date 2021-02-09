<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLanguageRequest;
use App\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::select('id', 'abbr', 'name', 'direction', 'active')->paginate(10);
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(AddLanguageRequest $request)
    {
        if (!$request->has('active')) {
            $status = '0';
        } else {
            $status = '1';
        }
        $language = Language::create([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'active' => $status,
            'direction' => $request->direction,
        ]);
        return redirect()->route('admin.languages')->with('success', "تم إضافة لغة جديدة بنجاح");
    }


    public function edit($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with('errors',"هذه اللغة غير موجودة");
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function update(AddLanguageRequest $request, $id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with('errors',"هذه اللغة غير موجودة");
        }

        $language->update([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'active' => $request->active,
            'direction' => $request->direction,
        ]);

        return redirect()->route('admin.languages')->with('success', "تم تعديل اللغة  بنجاح");
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with('errors',"هذه اللغة غير موجودة");
        }
        $language->delete();
        return redirect()->route('admin.languages')->with('success', "تم حذف اللغة بنجاح");
    }
}
