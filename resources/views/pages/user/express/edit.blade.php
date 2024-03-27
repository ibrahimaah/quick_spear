@extends('pages.user.express.index')

@section('expressContent')
<style>
    #shipments_form>div>div:nth-child(1)>div>#rmv-btn {
        visibility: hidden !important;
    }
</style>
<h2 class="mb-4">{{ __('Edit') }} {{ __('Local Shipping') }} #{{ $shipment->id }}</h2>


<div class="card">
    @if (session()->has('error'))
    <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
    <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    <div class="card-header">
        {{-- <h4>#1</h4> --}}
    </div>
    <div class="card-body">
        <div class="container">
            <form method="post" action="{{ route('front.express.update',['shipment'=>$shipment->id]) }}" id="shipments_form">
                @csrf


                <div class="row">
                    <div class="d-lg-flex flex-row col-sm-12 mb-3 justify-content-center">
                        <div class="col-sm-12 col-lg-4 px-0 mb-2">
                            <label>{{ __('Store Name') }}</label><span class="text-danger">*</span>
                            <select class="form-control mt-2 ml-2 " name="shipper">
                                @foreach (auth()->user()->addresses->where('type', 0)->all() as $address)
                                <option value="{{ $address->id }}" <?=$shipment->address_id == $address->id ? 'selected' : '' ?>>
                                    {{ $address->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <a href="{{ route('front.user.address') }}" style="height: 37px;margin-top: 3.3% !important;" class="btn btn-primary ml-xl-3 mr-xl-3 mx-3">
                            {{ __('New Address') }}
                        </a>



                    </div>
                    <hr />
                </div>
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Consignee Name') }}</label>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_name" value="{{ $shipment->consignee_name }}"/>
                        @error('consignee_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" id="phone_number" pattern="[0-9]{10}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" title="Please Enter Ten Digits" name="consignee_phone" value="{{ $shipment->consignee_phone }}" required />
                        @error('consignee_phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }} 2</label>
                        <input class="form-control mt-2 ml-2" type="number" name="consignee_phone_2" value="{{ $shipment->consignee_phone_2 }}"/>
                        @error('consignee_phone_2')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('City') }}</label><span class="text-danger">*</span>
                        <select class="form-control mt-2 ml-2" type="text" name="consignee_city" required>
                            @foreach (App\Models\City::get() as $city)
                            <option value="{{ $city->id }}" <?=$shipment->consignee_city == $city->id ? 'selected' : '' ?>>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('consignee_city')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Region') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_region" value="{{ $shipment->consignee_region }}" required />
                        @error('consignee_line2')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Order price includes delivery') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="number" name="order_price" value="{{ $shipment->order_price }}" required />
                        @error('order_price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>




                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Customer notes') }}</label>
                        <input class="form-control mt-2 ml-2" name="customer_notes" value="{{ $shipment->customer_notes }}" id="" cols="30" rows="3" />
                        @error('customer_notes')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Delegate notes') }}</label>
                        <input class="form-control mt-2 ml-2" name="delegate_notes" value="{{ $shipment->delegate_notes }}" id="" cols="30" rows="3" />
                        @error('delegate_notes')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>




                </div>
                <hr>


                <button class="btn btn-primary btn-lg my-3" type="submit">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
</div>


@endsection