<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditOrder as Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact(['orders']));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact(['order']));
    }

    public function update(Request $request, Order $order)
    {
        $rules = [
            'status'          => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput($request->all());
        }
        $data = [
            'status'            => $request->status,
        ];
        $order->update($data);
        return back()->with("success", "تم تعديل البيانات بنجاح");
    }


    public function destroy(Request $request, Order $order)
    {
        try{
            $order->delete();
            return back()->with("success","تم حذف البيانات بنجاح");
        }catch(\Exception $e){
            return back()->with("error",$e->getMessage());
        }
    }
}
