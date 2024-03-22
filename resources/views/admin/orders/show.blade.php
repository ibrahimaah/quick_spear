@extends('admin.layouts.app')
@section('title', 'الطلبات')
@section('pageTitle', 'الطلبات')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>تفاصيل الطلب</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="checkout-details">
                    <div class="order-box">
                        <div class="title-box">
                            <div class="checkbox-title">
                                <h4>رقم الطلب </h4><span>#{{ $order->code }}</span>
                            </div>
                        </div>
                        <ul class="qty">
                            <li>المنتج<span>{{ $order->product->name }}</span></li>
                            <li>الكمية<span>{{ $order->amount }}</span></li>
                            <li>الوحدة<span>{{ $order->unit }}</span></li>
                            <li>المشتري<span>{{ $order->user->name }}</span></li>
                            <li>تفاصيل اخرى<span>{{ $order->desc }}</span></li>
                            <li>الشركة<span>{{ $order->product->category->company->name ?? '' }}</span></li>
                            <li>القسم او النوع<span>{{ $order->product->category->name }}</span></li>
                        </ul>
                        <div class="order-place"><a class="btn btn-primary" href="{{ route('admin.orders.edit', $order->id) }}">تعديل الطلب</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
