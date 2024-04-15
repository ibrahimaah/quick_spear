@extends('admin.layouts.app')

@section('content')

<style>
   #shipments_form > div > div:nth-child(1) > div > #rmv-btn {
        visibility: hidden !important;
    }
    .datatable-container {
    overflow-x: auto;
    white-space: nowrap; /* Prevents text wrapping */
    }
</style> 
<h2 class="mb-4">{{ __('Create') }} {{ __('Local Shipping') }}</h2>

<div class="card">
   
    <div class="card-body">
        <div class="container">
            <form method="post" action="{{ route('admin.shipments.store') }}" id="shipments_form">
                @csrf
                <div data-x-wrapper="shipments">
                    <div data-x-group>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success mb-3" data-add-btn>
                                <i class="bi bi-plus-lg"></i>
                            </button>
                            <button type="button" class="btn btn-danger mb-3" id="rmv-btn" data-remove-btn>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <div class="row">
                            <div class="d-lg-flex flex-row col-sm-12 mb-3 justify-content-center">
                                <div class="col-sm-12 col-lg-4 px-0 mb-2">
                                    <label>{{ __('Store Name') }}</label><span class="text-danger">*</span>
                                    <select class="form-control mt-2 ml-2 " name="shipper" required>
                                        @foreach (auth()->user()->addresses->where('type', 0)->all() as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="{{ route('front.user.address') }}" 
                                style="height: 37px;margin-top: 3.3% !important;" 
                                class="btn btn-primary ml-xl-3 mr-xl-3 mx-3">
                                {{ __('New Address') }}
                                </a>
   
                            </div>
                            <hr />
                        </div>
                        <div class="row">
                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Consignee Name') }}</label>
                                <input class="form-control mt-2 ml-2" type="text" name="consignee_name"/>
                                @error('consignee_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" 
                                       type="text" 
                                       id="phone_number"
                                       pattern="[0-9]{10}" 
                                       onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                       title="Please Enter Ten Digits"
                                       name="consignee_phone" required/>
                                @error('consignee_phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Phone') }} 2</label>
                                <input class="form-control mt-2 ml-2" type="number" name="consignee_phone_2" />
                                @error('consignee_phone_2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div> 
                        

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('City') }}</label><span class="text-danger">*</span>
                                <select class="form-control mt-2 ml-2" type="text" name="consignee_city" required>
                                    @foreach (App\Models\City::get() as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('consignee_city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Region') }}</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="text" name="consignee_region" required/>
                                @error('consignee_line2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Order price includes delivery') }}</label><span class="text-danger">*</span>
                                <input class="form-control mt-2 ml-2" type="number" name="order_price" required/>
                                @error('order_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                      
                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Customer notes') }}</label>
                                <input class="form-control mt-2 ml-2" name="customer_notes" id="" cols="30" rows="3"/>
                                @error('customer_notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Delegate notes') }}</label>
                                <input class="form-control mt-2 ml-2" name="delegate_notes" id="" cols="30" rows="3"/>
                                @error('delegate_notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                      
                        
                            

                        </div>
                        <hr>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg my-3" type="submit">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
</div>


    

    @php 
        $status_numbers = config('constants.STATUS_NUMBER');
    @endphp 
 
    <div class="card p-3">
        <select class="form-select w-25 m-1" id="shipment_status_select">
            <option value="">اختر حالةالشحنة</option>
            @foreach($status_numbers as $status_number)
            <option value="{{ $status_number }}">{{ getStatusInfo($status_number) }}</option>
            @endforeach
        </select>
       
      
        <div class="card-body datatable-container" id="myTabContent">
            {{ $dataTable->table() }}
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts() }}      
    @endpush
   





















<script src="{{ asset('assets/vendor/jquery/jquery_v3.7.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.replicate/jquery.replicate.js') }}"></script>
<script>
    const selector ='[data-x-wrapper]';

    let options = {
        disableNaming:'[data-disable-naming]',
        wrapper: selector,
        group:'[data-x-group]',
        addBtn:'[data-add-btn]',
        removeBtn:'[data-remove-btn]'
    };

    $(selector).replicate(options);

    $(()=>{
        $('input[type=text]:not(#phone_number)').on('keydown',(e)=>{
            if((/\d/g).test(e.key)) e.preventDefault();
        })
        // $('#phone_number').on('keydown',(e)=>{
        //     if((/\d/g).test(e.key)) e.preventDefault();
        // })
    });
</script>
@endsection
