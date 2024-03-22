@extends('admin.layouts.app')
@section('title', 'تعديل مستخدم')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>#1</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <form method="post" action="{{ route('admin.shipments.update', $shipment->id) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="d-lg-flex flex-row col-sm-12 mb-3 justify-content-center">
                                <div class="col-xl-8 col-sm-12 col-lg-8 px-0 mx-2 mb-2">
                                    <label>اسم المتجر/المحل</label><span class="text-danger">*</span>
                                    <select class="form-control mt-2 ml-2 " name="shipper">
                                        @foreach ($shipment->user->addresses->all() as $address)
                                        <option {{ $shipment->address_id == $address->id ? 'selected' : '' }} value="{{ $address->id }}">
                                            {{ "الاسم : " . ($address->name ?? '') . "           | المدينة : " . ($address->City->name ?? "") . "           | الوصف :" . $address->desc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            {{--
                                <div class="col-xl-4 col-sm-12 col-lg-4
                                      px-0 px-sm-0
                                      mb-2
                                      ml-xl-3
                                      mt-2 mt-lg-0">
                                    <label>الناقل</label><span class="text-danger">*</span>
                                    <select class="form-control mt-2" name="provider">
                                        <option value="aramex" selected>Aramex</option>
                                    </select>
                                </div> 
                            --}}
                            </div>
                            <hr />
                        </div>
                        <div class="row">
                            <div class="col-12 my-2 col-md-4">
                                <label>اسم المستلم / الزبون</label>
                                <input class="form-control mt-2 ml-2" type="text" name="consignee_name" value="{{ $shipment->consignee_name }}" />
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>رقم الهاتف</label><span class="text-danger">*</span>
                                <input  class="form-control mt-2 ml-2" 
                                        type="text" 
                                        id="consignee_phone"
                                        pattern="[0-9]{10}" 
                                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                        title="Please Enter Ten Digits" 
                                        name="consignee_phone" 
                                        value="{{ $shipment->consignee_phone }}"
                                 />
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>رقم الهاتف البديل</label>
                                <input class="form-control mt-2 ml-2" type="number" name="consignee_phone_2" value="{{ $shipment->consignee_phone_2 }}" />
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>المدينة</label><span class="text-danger">*</span>
                                <select class="form-control mt-2 ml-2" type="text" name="consignee_city">
                                    @foreach (App\Models\City::get() as $city)
                                        <option {{ $shipment->consignee_city == $city->id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>المنطقة</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="text" name="consignee_region" value="{{ $shipment->consignee_region }}" />
                            </div>
                            

                            <div class="col-12 my-2 col-md-4">
                                <label>سعر الطلب شامل التوصيل</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" 
                                       type="number"
                                       name="order_price" 
                                       value="{{ $shipment->order_price }}"
                                       required/>
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>ملاحظات</label>
                                <input class="form-control mt-2 ml-2" type="text" name="notes" value="{{ $shipment->notes }}" />
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label for="message-text" class="col-form-label">حالة الشحنة</label>
                                <select name="status" class="form-control" id="">
                                    <option value="0" <?=$shipment->status == '0' ? 'selected' : '' ?>>جديد</option>
                                    <option value="1" <?=$shipment->status == '1' ? 'selected' : '' ?>>قيد المراجعة</option>
                                    <option value="2" <?=$shipment->status == '2' ? 'selected' : '' ?>>تم التوصيل</option>
                                    <option value="3" <?=$shipment->status == '3' ? 'selected' : '' ?>>مرتجع</option>
                                    <option value="4" <?=$shipment->status == '4' ? 'selected' : '' ?>>في انتظار الدفع</option>
                                    <option value="5" <?=$shipment->status == '5' ? 'selected' : '' ?>>تم الدفع بنجاح</option>
                                </select>
                            </div>
                        {{--   
                            <div class="col-12 my-2 col-md-4">
                                <label>وصف العنوان</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="text" name="consignee_line1" value="{{ $shipment->consignee_line1 }}" />
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>المحتويات</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="text" name="description" value="{{ $shipment->description }}" />
                            </div>
                            
                            <div class="col-12 my-2 col-md-4">
                                <label>القطع</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="text" name="number_of_pieces" value="{{ $shipment->number_of_pieces }}"/>
                            </div>
                            <div class="col-12 my-2 col-md-4">
                                <label>الدفع عند الإستلام(JOD)</label>
                                <input class="form-control mt-2 ml-2" type="text" name="cash_on_delivery_amount" value="{{ $shipment->cash_on_delivery_amount }}" />
                            </div>

                        --}}
                        </div>
                        <button class="btn btn-primary btn-lg my-3" type="submit">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 


@endsection
