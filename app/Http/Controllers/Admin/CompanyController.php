<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    
    public function create()
    {
        return view('admin.companies.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar'     => 'required',
            'name_en'     => 'required',
            'name_ku'     => 'required',
            'photo'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        Company::create([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ],
            'photo' => $request->file('photo') ? uploadImage('companies', $request->file('photo')) : 'images/default.png'
        ]);
        return redirect()->route('admin.companies.index')->with("success","تم اضافة البيانات بنجاح");
    }

    
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact(['company']));
    }

    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name_ar'     => 'required',
            'name_en'     => 'required',
            'name_ku'     => 'required',
            'photo'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        if ($request->hasFile('photo')) {
            if ($company->photo != 'images/default.png') {
                Storage::delete($company->photo);
            }
            $imagePath = uploadImage('companies', $request->file('photo'));
        }
        $company->update([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ],
            'photo' => $imagePath ?? $company->photo
        ]);
        return redirect()->route('admin.companies.index')->with("success","تم اضافة البيانات بنجاح");
    }

    public function destroy(Company $company)
    {
        if ($company->photo !== 'images/default.png') {
            Storage::delete($company->photo);
        }
        $company->delete();
        return redirect()->route('admin.companies.index')->with("success","تم حذف البيانات بنجاح");
    }
}
