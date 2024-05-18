<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use Aramex;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Address;
use App\Models\Company;
use App\Models\Document;
use App\Models\Shipment;
use App\Models\EditOrder;
use App\Models\TeamMember;
use App\Models\ShipmentRate;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Services\AddressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
    public function __construct(private AddressService $addressService)
    {
        $this->middleware(['auth']);
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $shop_id = $user->shop->id;
        $shop_id = $user->shop->id;
        $new_users_count= [];
        $days_list = [];
        $counts_list = [];
        $counts_list1 = [];
        $counts_list2 = [];
        $counts_list3 = [];
        $date_from = Carbon::parse($request->from ?? now()->subDays(30));
        $to = Carbon::parse($request->to ?? now());
        $days = $date_from->diffInDays($to);
        for ($i = 0 ; $i < $days && $i < 30  ; $i++) {
            array_push($days_list, $to->format('m-d'));
            array_push($counts_list, Shipment::where('shop_id', $shop_id)->where('status', 0)->whereDate('created_at', $to->format('Y-m-d'))->count());
            array_push($counts_list1, Shipment::where('shop_id', $shop_id)->where('status', 1)->whereDate('created_at', $to->format('Y-m-d'))->count());
            array_push($counts_list2, Shipment::where('shop_id', $shop_id)->where('status', 2)->whereDate('created_at', $to->format('Y-m-d'))->count());
            array_push($counts_list3, Shipment::where('shop_id', $shop_id)->where('status', 3)->whereDate('created_at', $to->format('Y-m-d'))->count());
            $to = $to->subDays(1);
        }
        $shipment_count=[
            'days_list'=>$days_list,
            'counts_list'=>$counts_list,
            'counts_list1'=>$counts_list1,
            'counts_list2'=>$counts_list2,
            'counts_list3'=>$counts_list3,
        ];

        // $shipment = Shipment::where('user_id', auth()->user()->id)->get();
        $shipment = Shipment::where('shop_id', $shop_id)->get();

        return view('pages.user.dashboard', compact('shipment', 'shipment_count', 'date_from', 'to'));
    }

    public function account()
    {
        $editOrders = EditOrder::where('user_id', auth()->user()->id)->latest()->get();
        return view('pages.user.account.account-details', compact('editOrders'));
    }

    public function account_update(Request $request)
    {
        $editOrder = EditOrder::create([
            'type'      => 'تعديل بيانات الحساب الشخصي',
            'desc' => "شرح التعديلات المطلوبة <br /> الاسم : $request->name <br /> البريد الالكتروني : $request->email <br /> رقم الهاتف : $request->phone",
            'user_id'   => auth()->user()->id,
        ]);

        return back()->with('success', 'تم ارسال طلبك بنجاح');
    }

    public function address()
    {
        $addresses = $this->addressService->getUserAddresses();
        return view('pages.user.account.address', compact('addresses'));
    }


    public function address_store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        try 
        {
            $address = $this->addressService->store($validated);

            return back()->with('success', 'تم اضافة العنوان بنجاح');
        } catch (\Exception $e) {
            return $e->getMessage();
            // return back()->with('error', $e->getMessage());
        }
    }

    public function address_delete($id)
    {
        $res = $this->addressService->remove($id);
        if ($res) 
        {
            return back()->with('success', 'تم حذف العنوان بنجاح');
        }
        return back()->with('error', 'لم يتم العثور علي العنوان المطلوب');
    }



    public function documents()
    {
        $user = auth()->user();
        $documents = Document::where('user_id', $user->id)->latest()->get();
        return view('pages.user.account.documents', compact('user', 'documents'));
    }


    public function documents_store(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'document' => 'required',
            'type' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $document = Document::create([
                'document' => uploadImage($user->id . '/documents', $request->document),
                'user_id'   => $user->id,
                'type' => $request->type,
                'statusVerify' => 0,
                'created_at' => now()->timestamp,
                'updated_at' => null,
            ]);

            return back()->with('success', __('The action ran successfully!'));
        } catch (\Exception $e) {
            // return $e->getMessage();
            return back()->with('error', $e->getMessage());
        }
    }

    public function documents_delete($id)
    {
        $user = auth()->user();
        $document = Document::where(['id'=>$id,'user_id' => $user->id])->first();
        if ($document) {
            $document->delete();
            return back()->with('success', __('The action ran successfully!'));
        }
        return back()->with('error', 'لم يتم العثور علي العنوان المطلوب');
    }

    public function payment_methods()
    {
        $user = auth()->user();
        $payment_methods = PaymentMethod::where('user_id', $user->id)->latest()->get();
        return view('pages.user.account.payment_methods', compact('user', 'payment_methods'));
    }


    public function payment_method_store(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'name' => 'required',
            'provider' => 'required',
            'iban_or_number' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $payment = PaymentMethod::create([
                'name' => $request->name,
                'user_id'   => $user->id,
                'provider' => $request->provider,
                'iban_or_number' => $request->iban_or_number,
            ]);

            return back()->with('success', 'تم اضافة العنوان بنجاح');
        } catch (\Exception $e) {
            return $e->getMessage();
            // return back()->with('error', $e->getMessage());
        }
    }

    public function payment_method_delete($id)
    {
        $user = auth()->user();
        $address = Address::where(['id'=>$id,'user_id' => $user->id])->first();
        if ($address) {
            $address->delete();
            return back()->with('success', 'تم حذف العنوان بنجاح');
        }
        return back()->with('error', 'لم يتم العثور علي العنوان المطلوب');
    }


    public function teams()
    {
        $user = auth()->user();
        $teams = TeamMember::where('user_id', $user->id)->latest()->get();
        return view('pages.user.account.team', compact('user', 'teams'));
    }


    public function team_store(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $password = \Str::random(8);
            $team = TeamMember::create([
                'name' => $request->name,
                'user_id'   => $user->id,
                'role' => $request->role,
                'email' => $request->email,
                'phone' => $request->phone,
                'account_number' => $request->phone,
                'password' => Hash::make($password),
            ]);
            $message = "UserName : $request->email \r\n";
            $message .= "Password : $password \r\n";
            $message .= "Link : " . asset('/');

            mail($request->email, 'Add You To Our Team', $message);
            return back()->with('success', 'تم اضافة العضو بنجاح');
        } catch (\Exception $e) {
            return $e->getMessage();
            // return back()->with('error', $e->getMessage());
        }
    }

    public function team_delete($id)
    {
        $user = auth()->user();
        $address = TeamMember::where(['id'=>$id,'user_id' => $user->id])->first();
        if ($address) {
            $address->delete();
            return back()->with('success', 'تم حذف العضو بنجاح');
        }
        return back()->with('error', 'لم يتم العثور علي العضو المطلوب');
    }



    public function aramex_account()
    {
        $company = Company::where('user_id', auth()->user()->id)->first();
        return view('pages.user.account.company', compact('company'));
    }

    public function aramex_account_update(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'AccountNumber' => 'required',
            'UserName'  => 'required',
            'Password'  => 'required',
            'AccountPin'    => 'required',
            'AccountEntity' => 'required',
            'AccountCountryCode'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $company = Company::updateOrCreate(['user_id' => $user->id], [
                'AccountNumber' => $request->AccountNumber,
                'UserName'  => $request->UserName,
                'Password'  => $request->Password,
                'AccountPin'    => $request->AccountPin,
                'AccountEntity' => $request->AccountEntity,
                'AccountCountryCode'    => $request->AccountCountryCode,
                'Version'   => $request->Version ?? 'v1',
            ]);

            return back()->with('success', '');
        } catch (\Exception $e) {
            return $e->getMessage();
            // return back()->with('error', $e->getMessage());
        }
    }


    public function localPrice()
    {
        $rates = ShipmentRate::latest()->get();
        return view('pages.user.account.rates', compact('rates'));
    }
}
