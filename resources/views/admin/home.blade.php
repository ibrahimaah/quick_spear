{{-- @dd(auth()->user()->notifications) --}}
@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('pageTitle', 'الرئيسية')
@section('content')
    <div class="row">
        <div class="card col-6">
            <div class="card-body">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        إجرائات سريعة
                    </div>
                    <div class="col-12 divider" style="min-height: 2px;"></div>
                </div>
                <div class="col-12 p-3 row d-flex">
                    <div class="col-4  d-flex justify-content-center align-items-center mb-3 py-2">
                        <a href="{{ route('admin.import.create') }}" style="color:inherit;">
                            <div class="col-12 p-0 text-center">
                                <span class="fa fa-arrow-up fa-3x"></span>
                                <div class="col-12 p-0 text-center">
                                    تحميل شيت شحنات
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4 d-flex justify-content-center align-items-center mb-3 py-2">
                        <a href="{{ route('admin.shipments.index') }}" style="color:inherit;">
                            <div class="col-12 p-0 text-center">
                                <span class="fa fa-truck fa-3x"></span>
                                <div class="col-12 p-0 text-center">
                                    الشحنات
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-4 d-flex justify-content-center align-items-center mb-3 py-2 card">
                        <a href="{{ route('admin.requests.index') }}" style="color:inherit;">
                            <div class="col-12 p-0 text-center card-body">
                                <span class="fa fa-edit fa-3x"></span>
                                <div class="col-12 p-0 text-center">
                                    عرض كل طلبات الدفع
                                    منتظر : ({{ App\Models\PaymentRequest::where('status', 0)->count() }}) <br />
                                    تم : ({{ App\Models\PaymentRequest::where('status', 1)->count() }})
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
