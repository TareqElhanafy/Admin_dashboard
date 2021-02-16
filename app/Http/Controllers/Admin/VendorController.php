<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MainCategory;
use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::select()->paginate(10);
        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        $categories = MainCategory::where('trans_lang',get_default_lang())->active()->get();
        return view('admin.vendor.create', compact('categories'));
    }
}
