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
    #shipments_form > div > div > div:nth-child(3) > div:nth-child(8) > span > span.selection > span,
    #shipments_form > div > div > div:nth-child(3) > div:nth-child(4) > span.select2.select2-container.select2-container--default > span.selection > span
    {
        margin-top : 0.5rem !important;
    }
</style> 




 

@if(session()->has('error_delete'))
    <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error_delete') }}</div>
@endif
@if(session()->has('success_delete'))
    <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success_delete') }}</div>
@endif


{{-- <h2 class="mb-4">{{ __('Create') }} {{ __('Local Shipping') }}</h2> --}}
<h2 class="mb-4">إنشاء شحنة</h2>

<div class="card">
   
    @if(session()->has('error'))
        <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if(session()->has('success'))
        <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif

   

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

                                    {{-- <select class="form-control mt-2 ml-2" id="addresses-select2" name="shipper" required>
                                        @foreach ($addresses as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->name }}
                                        </option>
                                        @endforeach
                                    </select> --}}

                                    <select class="form-control mt-2 ml-2" id="shops-select2" name="shop" required>
                                        @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}">
                                            {{ $shop->name }}
                                        </option>
                                        @endforeach
                                    </select>


                                </div>
                                {{-- <a href="{{ route('admin.address.index') }}" 
                                style="height: 37px;margin-top: 3.3% !important;" 
                                class="btn btn-primary ml-xl-3 mr-xl-3 mx-3">
                                {{ __('New Address') }}
                                </a> --}}
   
                            </div>
                            {{-- <hr /> --}}
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
                                <select 
                                        class="form-control mt-2 ml-2" 
                                        id="cities-select2" 
                                        type="text" 
                                        name="consignee_city" 
                                        required
                                >
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
                                <input class="form-control mt-2 ml-2" name="customer_notes" />
                                @error('customer_notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label class="mb-2 d-block">{{ __('Delegate Name') }}</label>
                                {{-- <select id="choose-delegate-select2" name="delegate" required>
                                    @if($delegates->isNotEmpty())
                                        @foreach($delegates as $delegate)
                                        <option value="{{ $delegate->id }}">{{ $delegate->name }}</option> 
                                        @endforeach
                                    @endif
                                </select> --}}
                                <select id="choose-delegate-select2" name="delegate" required>
                                    
                                        
                                    {{-- @endif --}}
                                </select>
                            </div>

                            <div class="col-12 my-2 col-md-4">
                                <label>{{ __('Delegate notes') }}</label>
                                <input class="form-control mt-2 ml-2" name="delegate_notes" />
                                @error('delegate_notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                      
                        </div>
                        <hr>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg my-3" id="save_shipment_btn" type="submit">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
</div>


    
 

 

    @push('js')

    <script>

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
            // $('#delegates-select2').select2();

            // $('#delegates-select2').select2({
            //     dropdownParent: $('#assign-delegate-modal')
            // });

            $('#choose-delegate-select2').select2();
            // $('#addresses-select2').select2();
            $('#shops-select2').select2();
            $('#cities-select2').select2();

            var initialCityId = $('#cities-select2').val();
            if (initialCityId) {
                fetchDelegates(initialCityId);
            }

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
