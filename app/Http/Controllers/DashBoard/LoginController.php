<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function logout()
    {
        $guard = $this->getGuard();
        $guard->logout();

        return redirect()->route('admin.login');
    }

    public function getGuard()
    {
        return auth('admin');
    }

    public function postAdminLogin(AdminLoginRequest $request)
    {
        $remember_me = $request->has('remember-me') ? true : false;
        if(auth()->guard('admin')->attempt(['email' => $request->input('email'),
            'password' => $request->input('password')], $remember_me)) {
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with(['error' => 'The information is wrong']);
    }
}
