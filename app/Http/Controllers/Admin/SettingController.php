<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        foreach(User::get() as $user){
            $user->update(['account_number' => $this->generateAccountNumber()]);
        }

        $setting = Setting::first();
        return view('admin.setting.index', compact(['setting']));
    }

    public function update(Request $request)
    {
        try{
            $rules = [
                'logo' => 'nullable|image',
                'website_name' => 'required|string|max:50',
                'first_char_account_number' => 'required|string|max:50',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput($request->all());
            }

            $setting = Setting::first();
            if ($request->hasFile('logo')) {
                $setting->update([
                    'website_logo' => uploadImage('logo', $request->file('logo')) ?? $setting->website_logo,
                ]);
            }

            $setting->update([
                'website_name' => $request->website_name,
                'website_email' => $request->website_email ?? 'info@donmin.com',
                'first_char_account_number' => $request->first_char_account_number,
            ]);
            return back()->with("success","تم تعديل البيانات بنجاح");
        }catch(\Exception $e){
            return back()->with("error",$e->getMessage());
        }
    }
}
