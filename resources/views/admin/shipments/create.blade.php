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


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@if (session()->has('error'))
	<div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
@endif
@if (session()->has('success'))
	<div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
@endif

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
                                        @foreach ($addresses as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="{{ route('admin.address.index') }}" 
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
       
        <button id="assign-shipment-btn" class="btn btn-primary w-25 m-1">إسناد لمندوب</button>
        <div class="admin-shipments">
            <div class="card-body datatable-container" id="myTabContent">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="assign-delegate-modal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إسناد شحنة/شحنات لمندوب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <p id="selected-ids"></p>
                <form action="{{ route('admin.assign_delegate') }}" method="post">
                    @csrf 
                    <input type="hidden" id="selected-shipments-ids-input" name="selected_shipments" value="">

                    <select id="delegates-select2" name="delegate" required>
                    <option value="">اختر مندوب</option> 
                    @if($delegates->isNotEmpty())
                        @foreach($delegates as $delegate)
                        <option value="{{ $delegate->id }}">{{ $delegate->name }}</option> 
                        @endforeach
                    @endif
                    </select>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">خروج</button>
            </div>
            </form>
            </div>
        </div>
    </div>


    @push('scripts')
    {{ $dataTable->scripts() }}      
    @endpush

    @push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() 
        {
            $('#delegates-select2').select2();

            $('#delegates-select2').select2({
                dropdownParent: $('#assign-delegate-modal')
            });

            


            var dataTable = $('#express-table').DataTable();
            var selectedIds = [];
            var assignButton = $('#assign-shipment-btn');

            // Function to enable/disable the button based on the selectedIds array
            function toggleButtonState() {
                if (selectedIds.length > 0) {
                    assignButton.prop('disabled', false); // Enable the button
                } else {
                    assignButton.prop('disabled', true); // Disable the button
                }
            }

            // Event listener for checkbox changes
            $('#express-table').on('change', 'input[type="checkbox"]', function() {
                if (this.checked) {
                    var id = $(this).val();
                    if (selectedIds.indexOf(id) === -1) {
                        selectedIds.push(id);
                    }
                } else {
                    var id = $(this).val();
                    var index = selectedIds.indexOf(id);
                    if (index !== -1) {
                        selectedIds.splice(index, 1);
                    }
                }
                toggleButtonState(); // Update button state
                console.log(selectedIds);
            });

            // Event listener for assign button click
            assignButton.on('click', function() {
                // Show Bootstrap modal and display selected ids inside it
                if (selectedIds.length > 0) {
                    $('#assign-delegate-modal').modal('show');
                    $('#selected-shipments-ids-input').val(selectedIds); 
                    // $('#selected-ids').text(' الشحنات التي ستم إسنادها'+selectedIds.join('#, ')); // Display selected ids inside the modal
                }
            });

            // Initialize button state
            toggleButtonState();
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
