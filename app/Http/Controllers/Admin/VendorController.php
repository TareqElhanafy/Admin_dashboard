<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddVendorRequest;
use App\MainCategory;
use App\Notifications\VendorCreated;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::select()->paginate(10);
        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        $categories = MainCategory::where('trans_lang', get_default_lang())->active()->get();
        return view('admin.vendor.create', compact('categories'));
    }

    public function store(AddVendorRequest $request)
    {
        if ($request->has('logo')) {
            $logo = $request->logo->store('vendors');
        }

        if (!$request->has('active')) {
            $request->request->add(['active' => '0']);
        } else {
            $request->request->add(['active' => '1']);
        }

        $vendor = Vendor::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'active' => $request->active,
            'category_id' => $request->category_id,
            'logo' => $logo,
            'password' => $request->password
        ]);

        // Notification::send($vendor, new VendorCreated($vendor));

        return redirect()->route('admin.vendors')->with('success', 'تم إضافة متجر جديد بنجاح');
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);
        if (!$vendor) {
            return redirect()->route('admin.vendors')->with('error', 'هذا المتجر غير موجود');
        }
        $categories = MainCategory::where('trans_lang', get_default_lang())->active()->get();
        return view('admin.vendor.edit', compact('vendor', 'categories'));
    }

    public function update(AddVendorRequest $request, $id)
    {


        $vendor = Vendor::find($id);

        if (!$vendor) {
            return redirect()->route('admin.vendors')->with('error', 'هذا المتجر غير موجود');
        }

        $data = $request->only(['name', 'email', 'active', 'address', 'mobile', 'category_id']);

        if ($request->has('logo')) {
            $logo = $request->logo->store('vendors');
        } else {
            $logo = $vendor->logo;
        }

        $data['logo'] = $logo;

        if ($request->has('password')) {
            $data['password'] = $request->password;
        }

        if (!$request->has('active')) {
           $data['active'] = '0';
        } else {
            $data['active'] = '1';
        }
        $vendor->update($data);

        return redirect()->route('admin.vendors')->with('success', 'تم تعديل بيانات المتجر بنجاح');
    }
}
