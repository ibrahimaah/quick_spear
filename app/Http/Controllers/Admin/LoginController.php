<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function getLogin()
    {
        // Admin::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@email.com',
        //     'phone' => '01022844240',
        //     'password' => bcrypt('123456'),
        // ]);
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;
        $password= $request->input('password');

        if (Auth::guard('admin')->attempt(['phone' => $request->input('phone') , 'password'=> $password] ,
        $remember_me)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.getLogin')->with('error', 'هناك خطا بالبيانات');
    }

}
