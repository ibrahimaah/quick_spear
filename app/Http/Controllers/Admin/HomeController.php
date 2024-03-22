<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function mode(Request $request)
    {
        $user = auth('admin')->user();
        $user->update([
            'dark'=> $user->dark == 0 ? 1 : 0,
        ]);
        return back();
    }
}
