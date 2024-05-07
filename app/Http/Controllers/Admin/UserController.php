<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExpressDataTable;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Document;
use App\Models\PaymentMethod;
use App\Models\ShipmentRate;
use App\Models\User as user;
use App\Services\UserService;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GeneralTrait;
    public function __construct(private UserService $userService)
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
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
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
        if ($res_store_user['code'] == 1) {
            return redirect()->route('admin.users.index')->with("success", "تم اضافة البيانات بنجاح");
        }else{
            return redirect()->route('admin.users.index')->with("error", $res_store_user['msg']);
        }
        
    }

    public function show(user $user)
    {
        $dataTable = new ExpressDataTable([],true,$user->id);
        $payments = PaymentMethod::where('user_id', $user->id)->latest()->get();
        $documents = Document::where('user_id', $user->id)->latest()->get();
        $rates = ShipmentRate::latest()->get();
        return $dataTable->render('admin.users.show',['user'=>$user,'rates'=>$rates,'documents'=>$documents,'payments'=>$payments]);
        // return $dataTable->render('admin.users.show');
    }

    public function edit(user $user)
    {
        return view('admin.users.edit', compact(['user']));
    }
    public function update(Request $request, user $user)
    {
        $rules = [
            'name'      => 'required',
            // 'password'  => 'required',
            'phone'     => 'required',
            'email'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $user->update([
            'name'       => $request->name,
            'phone'      => $request->phone,
            // 'password'   => $request->password ? Hash::make($request->password) : $user->password,
            'email'     => $request->email,
        ]);
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
}
