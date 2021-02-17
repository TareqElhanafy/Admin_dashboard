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
            'logo' => $logo
        ]);

    Notification::send($vendor, new VendorCreated($vendor));

        return redirect()->route('admin.vendors')->with('success', 'تم إضافة متجر جديد بنجاح');
    }
}
