@extends('admin.layouts.app')
@section('title', 'تعديل شحنة')
@section('content')

@php 
$status_numbers = config('constants.STATUS_NUMBER');
@endphp 


<div class="row">
    


    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>#{{ $shipment->id }}</h4>
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
                                    
                                    <select class="form-control mt-2 ml-2" id="shops-select2" name="shop" required>
                                        @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}" <?=$shipment?->shop?->id == $shop?->id ? 'selected' : '' ?>>
                                            {{ $shop->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- <select class="form-control mt-2 ml-2 " name="address">
                                        @foreach ($shipment->user->addresses->all() as $address)
                                        <option {{ $shipment->address_id == $address->id ? 'selected' : '' }} value="{{ $address->id }}">
                                            {{ "الاسم : " . ($address->name ?? '') . "           | المدينة : " . ($address->City->name ?? "") . "           | الوصف :" . $address->desc }}
                                        </option>
                                        @endforeach
                                    </select> --}}

                                </div>
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
                                <select 
                                    class="form-control mt-2 ml-2"
                                    type="text" id="cities-select2"
                                    name="consignee_city" 
                                    required
                                >
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
                                <label>القيمة عند التسليم</label>
                                <input class="form-control mt-2 ml-2" 
                                       type="number"
                                       name="value_on_delivery" 
                                       value="{{ $shipment->value_on_delivery }}"
                                       />
                            </div>



                            <div class="col-12 my-2 col-md-4">
                                <label>ملاحظات العميل</label>
                                <input class="form-control mt-2 ml-2" type="text" name="customer_notes" value="{{ $shipment->customer_notes }}" />
                            </div>


                            <div class="col-12 my-2 col-md-4">
                                <label class="mb-2 d-block">{{ __('Delegate Name') }}</label>
                                <select id="choose-delegate-select2" name="delegate" required>
                                    @if($delegates->isNotEmpty())
                                        @foreach($delegates as $delegate)
                                        <option value="{{ $delegate->id }}" <?= ($shipment->delegate_id == $delegate->id) ? 'selected' : ''?>>{{ $delegate->name }}</option> 
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="col-12 my-2 col-md-4">
                                <label>ملاحظات المندوب</label>
                                <input class="form-control mt-2 ml-2" type="text" name="delegate_notes" value="{{ $shipment->delegate_notes }}" />
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label for="message-text" class="col-form-label">حالة الشحنة</label>
                                <select class="form-select w-25 m-1" name="shipment_status_id" id="shipment_status_select">
                                    <option value="">اختر حالةالشحنة</option>
                                    @foreach($shipment_statuses as $shipment_status)
                                    <option value="{{ $shipment_status->id }}" <?=($shipment->shipment_status_id == $shipment_status->id) ? 'selected' : ''?>>{{ __($shipment_status->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="is_returned" value="1" type="checkbox" id="flexCheckDefault" @checked($shipment->is_returned)>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        هل يوجد مرتجع؟
                                    </label>
                                </div>
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


@push('js') 

    <script>
        var current_delegate_id = {{ $shipment->delegate->id }}
        
        function fetchDelegates(cityId) 
        {
            var url = "{{ route('admin.delegates.get_delegates_by_city_id', ['city' => 'CITY_ID_PLACEHOLDER']) }}";
            url = url.replace('CITY_ID_PLACEHOLDER', cityId);

            $.ajax({
                url: url,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() { 
                    $('#choose-delegate-select2').prop('disabled', true);
                    $('#save_shipment_btn').addClass('disabled-button');
                },
                complete: function() { 
                    $('#choose-delegate-select2').prop('disabled', false);
                    $('#save_shipment_btn').removeClass('disabled-button');
                },
                success: function(response) {
                    if (response.code == 1) {
                        var delegates = response.data;
                        var delegateSelect = $('#choose-delegate-select2');
                        delegateSelect.empty();
                        delegateSelect.append('<option value=""></option>'); // Add default empty option
                        $.each(delegates, function(index, delegate) {
                            // var selected = (current_delegate_id === delegate.id) ? ' selected' : '';
                            // delegateSelect.append('<option value="' + delegate.id + '"' + selected + '>' + delegate.name + '</option>');
                            delegateSelect.append('<option value="' + delegate.id + '">' + delegate.name + '</option>');
                        });
                    } else if (response.code == 0) {
                        alert('Error fetching delegates');
                    }
                },
                error: function() {
                    alert('An error occurred');
                }
            });
        }

        $(document).ready(function() 
        {
            $('#choose-delegate-select2').select2();
            
            
            $('#shipment_status_select').select2();
       
            // $('#delegates-select2').select2();

            // $('#delegates-select2').select2({
            //     dropdownParent: $('#assign-delegate-modal')
            // });

            // $('#choose-delegate-select2').select2();
            // $('#addresses-select2').select2();
            $('#shops-select2').select2();
            $('#cities-select2').select2();

            // var initialCityId = $('#cities-select2').val();
            // if (initialCityId) {
            //     fetchDelegates(initialCityId);
            // }

            // Fetch delegates on change event
            $('#cities-select2').on('change', function (e) {
                var cityId = $("option:selected", this).val();
                if (cityId) {
                    fetchDelegates(cityId);
                }
            });
        
            
            
        });

</script>

@endpush

  

