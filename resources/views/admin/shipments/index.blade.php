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


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

 

@if(session()->has('error_delete'))
    <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error_delete') }}</div>
@endif
@if(session()->has('success_delete'))
    <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success_delete') }}</div>
@endif

@if(session()->has('error_update'))
<div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error_update') }}</div>
@endif
@if(session()->has('success_update'))
<div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success_update') }}</div>
@endif


{{-- <h2 class="mb-4">{{ __('Create') }} {{ __('Local Shipping') }}</h2> --}}
<h2 class="mb-4">عرض الشحنات</h2>

    @php 
        $status_numbers = config('constants.STATUS_NUMBER');
    @endphp 
 
    <div class="card p-3">

       <div class="w-25">
        <select class="form-select w-25 m-1" id="shipment_status_select">
            <option value="">اختر حالةالشحنة</option>
            @foreach($shipment_statuses as $shipment_status)
            <option value="{{ $shipment_status->id }}">{{ __($shipment_status->name) }}</option>
            @endforeach
        </select>
       </div>
       
        <button id="assign-shipment-btn" class="btn btn-primary w-25 m-1">إسناد لمندوب</button>


        <form action="{{ route('admin.invoice') }}" method="get">
            @csrf 
            <input type="hidden" id="selected-shipments-ids-input-invoice" name="selected_shipments" value="">
            <button type="submit" id="invoice-btn" class="btn btn-primary w-25 m-1">فاتورة</button>
        </form>



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
                    {{-- @if($delegates->isNotEmpty())
                        @foreach($delegates as $delegate)
                        <option value="{{ $delegate->id }}">{{ $delegate->name }}</option> 
                        @endforeach
                    @endif --}}
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
        function getDelegatesByCityName(cityName) 
        {
            
            var url = "{{ route('admin.delegates.get_delegates_by_city_name', ['name' => 'CITY_ID_PLACEHOLDER']) }}";
            url = url.replace('CITY_ID_PLACEHOLDER', cityName);

            $.ajax({
                url: url,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {  
                    $('#delegates-select2').prop('disabled', true);
                    $('#assign-shipment-btn').addClass('disabled-button');
                },
                complete: function() { 
                    $('#delegates-select2').prop('disabled', false);
                    $('#assign-shipment-btn').removeClass('disabled-button');
                },
                success: function(response) {
                    if (response.code == 1) {
                        var delegates = response.data;
                        var delegateSelect = $('#delegates-select2');
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
            $('#delegates-select2').select2();

            $('#delegates-select2').select2({
                dropdownParent: $('#assign-delegate-modal')
            });

            $('#choose-delegate-select2').select2();
            // $('#addresses-select2').select2();
            $('#shops-select2').select2();
            $('#cities-select2').select2();

            $('#shipment_status_select').select2();
            var dataTable = $('#express-table').DataTable();
            var selectedIds = [];
            var assignButton = $('#assign-shipment-btn');
            var invoiceButton = $('#invoice-btn');

            // Function to enable/disable the button based on the selectedIds array
            function toggleButtonState() {
                if (selectedIds.length > 0) {
                    assignButton.prop('disabled', false); // Enable the button
                    invoiceButton.prop('disabled', false); // Enable the button
                } else {
                    assignButton.prop('disabled', true); // Disable the button
                    invoiceButton.prop('disabled', true);
                }
            }

            var selectedIds = [];
            var selectedCityName = null;

            $('#express-table').on('change', 'input[type="checkbox"]', function() {
                var id = $(this).val(); 

                var columnName = 'consignee_city'; // Replace 'columnName' with the actual name of your column
                var columnIndex = dataTable.column(columnName + ':name').index();
                var cityName = $(this).closest('tr').find('td:eq('+columnIndex+')').text().trim();
                console.log(cityName)
                if (this.checked) 
                {
                    if (selectedCityName === null) 
                    {
                        selectedCityName = cityName; // Set the initial city_id
                        selectedIds.push(id);
                        
                    } 
                    else if (selectedCityName === cityName) 
                    {
                        selectedIds.push(id); // Add the id if the city_id matches
                    } 
                    else 
                    {
                        alert('يجب أن تحتوي كافة الأسطر المحددة على نفس المدينة');
                        $(this).prop('checked', false); // Uncheck the checkbox
                    }
                } 
                else 
                {
                    var index = selectedIds.indexOf(id);
                    if (index !== -1) 
                    {
                        selectedIds.splice(index, 1); // Remove the id
                        if (selectedIds.length === 0) 
                        {
                            selectedCityName = null; // Reset city_id if no rows are selected
                        }
                    }
                }

                toggleButtonState(); // Update button state
                console.log(selectedIds);
            });

            // Event listener for assign button click
            assignButton.on('click', function() {
                // Show Bootstrap modal and display selected ids inside it
                if (selectedIds.length > 0) {
                    getDelegatesByCityName(selectedCityName) 
                    $('#assign-delegate-modal').modal('show');
                    $('#selected-shipments-ids-input').val(selectedIds); 
                    
                    
                    // $('#selected-ids').text(' الشحنات التي ستم إسنادها'+selectedIds.join('#, ')); // Display selected ids inside the modal
                }
            });


             // Event listener for invoice button click
             invoiceButton.on('click', function() 
             {
                // Show Bootstrap modal and display selected ids inside it
                if (selectedIds.length > 0) 
                {
                    $('#selected-shipments-ids-input-invoice').val(selectedIds); 
                }
            });


            // Initialize button state
            toggleButtonState();



            $('#shipment_status_select').on('change',function(){
                var columnName = 'shipment_status_id'; // Replace 'columnName' with the actual name of your column
                var columnIndex = dataTable.column(columnName + ':name').index();
                dataTable.column(columnIndex).search($(this).val()).draw()
            })
            
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
