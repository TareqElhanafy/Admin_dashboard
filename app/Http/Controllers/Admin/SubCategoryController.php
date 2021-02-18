<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MainCategory;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::select()->paginate(10);
        return view('admin.subcategories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = MainCategory::active()->get();
        return view('admin.subcategories.create', compact('categories'));
    }
}
