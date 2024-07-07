<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExpressDataTable;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Document;
use App\Models\PaymentMethod;
use App\Models\ShipmentRate;
use App\Models\User;
use App\Services\ShopService;
use App\Services\UserService;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GeneralTrait;
    public function __construct(private UserService $userService,
                                private ShopService $shopService)
    {
        // $this->middleware(['super_admin']);
    }
    public function index()
    {
        $users = user::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required|string|min:8|max:30|unique:users,name',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'phone'     => 'required|numeric|unique:users,phone',
            'password'  => 'required|string|confirmed',
            'shop_name' => 'required',
            'city'      => 'required',
            'region'    => 'required',
            'description'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $user_date = [
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'account_number'=> $this->generateAccountNumber(),
            'password'      => Hash::make($request->password),
        ];

        $res_store_user = $this->userService->store($user_date);
        
        if ($res_store_user['code'] == 1) 
        {
            $user = $res_store_user['data'];
            $shop_date = [
                'user_id'     => $user->id,
                'name'   => $request->shop_name,
                'city_id'        => $request->city,
                'region'      => $request->region,
                'description' => $request->description,
                'region'      => $request->region
            ];
            $res_store_shop = $this->shopService->store($shop_date);

            if ($res_store_shop['code'] == 1) 
            {
                // return redirect()->route('admin.users.index')->with("success_store", "تم اضافة البيانات بنجاح");
                return back()->with("success_store", "تم اضافة البيانات بنجاح");
            }
            else 
            {
                $user->delete();
                // return redirect()->route('admin.users.index')->with("error", $res_store_shop['msg']);   
                return back()->with("error", $res_store_shop['msg']);   
            }
            
        }
        else
        {
            // return redirect()->route('admin.users.index')->with("error", $res_store_user['msg']);
            return back()->with("error", $res_store_user['msg']);
        }
        
    }

    public function show(user $user)
    {
        $shop = $user->shop;
        return view('admin.users.show',['user'=>$user,'shop'=>$shop]); 
    }

    public function edit(user $user)
    {
        return view('admin.users.edit', compact(['user']));
    }
    public function update(Request $request, user $user)
    {
        // dd($request->all());
        $rules = [
            'name'        => 'required|string|min:8|max:30|unique:users,name,' . $user->id,
            'email'       => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'       => 'required|numeric|unique:users,phone,' . $user->id,
            'shop_name'   => 'required',
            'city'        => 'required',
            'region'      => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $user_data = [
            'name'       => $request->name,
            'phone'      => $request->phone,
            'email'     => $request->email
        ];
        $user->update($user_data);

        $shop = $user->shop;

        $shop_data = [
            'name' => $request->shop_name,
            'city_id' => $request->city,
            'region' => $request->region,
            'description' => $request->description,
        ];

        $shop->update($shop_data);

        return redirect()->route('admin.users.index')->with("success", "تم تعديل البيانات بنجاح");
    }

    public function destroy(user $user)
    {
        // if ($user->photo !== 'images/default.png') {
        //     Storage::delete($user->photo);
        // }
        $user->delete();
        return redirect()->route('admin.users.index')->with("success", "تم حذف البيانات بنجاح");
    }


    public function documents_delete($document)
    {
        $document = Document::findOrFail($document);
        $document->delete();
        return back()->with("success", "تم حذف البيانات بنجاح");
    }

    public function payments_delete($payment)
    {
        $payment = PaymentMethod::findOrFail($payment);
        $payment->delete();
        return back()->with("success", "تم حذف البيانات بنجاح");
    }


    public function payments_update(Request $request, $payment)
    {
        $payment = PaymentMethod::findOrFail($payment);
        $rules = [
            'status'      => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $payment->update([
            'status' => $request->status,
            'updated_at' => now()->timestamp,
        ]);
        return back()->with("success", "تم تعديل البيانات بنجاح");
    }

    public function documents_update(Request $request, $document)
    {
        $document = Document::findOrFail($document);
        $rules = [
            'status'      => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $document->update([
            'statusVerify' => $request->status,
            'updated_at' => now()->timestamp,
        ]);
        return back()->with("success", "تم تعديل البيانات بنجاح");
    }

    public function update_password(Request $request,User $user)
    {
        
        $validator = Validator::make($request->all(), [
            // 'current_password' => ['required','current_password'],
            'new_password' => ['required','confirmed','min:6'],
            'new_password_confirmation' => ['required']
        ]);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput($request->all()); }

        $res_update_pwd = $this->userService->update_pwd($request->new_password,$user);

        if ($res_update_pwd['code'] == 1)
        {
            return redirect()->route('admin.users.index')->with("success", "تم تعديل كلمة المرور بنجاح");
        }
        else 
        {
            dd($res_update_pwd['msg']);
        }

    }

}
