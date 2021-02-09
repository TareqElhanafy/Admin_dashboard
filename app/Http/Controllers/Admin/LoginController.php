<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        $remember = $request->has('remember_me') ? true : false;
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('admin.dashboard')->with(['success'], 'تم تسجيل الدخول بنجاح');
        } else {
            return redirect()->back();
        }
    }
}
