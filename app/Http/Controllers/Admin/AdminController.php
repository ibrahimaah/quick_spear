<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin as user;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['super_admin']);
    }
    public function index()
    {
        $users = user::where('name', '!=', 'shipybuy')->latest()->get();
        return view('admin.admins.index', compact('users'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        try{

        $rules = [
            'name'      => 'required',
            'password'  => 'required',
            'phone'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        user::create([
            'name'       => $request->name,
            'email'      => $request->name,
            'phone'      => $request->phone,
            'dark'       => 0,
            'password'   => Hash::make($request->password),
        ]);
        return redirect()->route('admin.admins.index')->with("success","تم اضافة البيانات بنجاح");
    }catch(\Exception $e){
        return $e->getMessage();
    }
    }

    public function edit($user)
    {
        $user = user::findOrFail($user);
        return view('admin.admins.edit', compact('user'));
    }

    public function update(Request $request, $user)
    {
        $user = user::findOrFail($user);
        $rules = [
            'name'      => 'required',
            'password'  => 'nullable',
            'phone'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $user->update([
            'name'       => $request->name,
            'email'      => $request->name,
            'phone'      => $request->phone,
            'password'   => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        return redirect()->route('admin.admins.index')->with("success","تم تعديل البيانات بنجاح");
    }

    public function destroy($user)
    {
        $user = user::findOrFail($user);
        $user->delete();
        return redirect()->route('admin.admins.index')->with("success","تم حذف البيانات بنجاح");
    }
}
