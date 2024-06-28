@extends('admin.layouts.app')
@section('title', 'شحنات مندوب')
@section('content')

 
<div class="row mt-5">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5>
                        @if($delegate)
                        <span>الشحنات الخاصة بالمندوب</span><span class="text-success"> {{ $delegate->name }}</span>
                        @else 
                        <span>الشحنات</span>
                        @endif
                    </h5>
                    <h5>
                        <a href="{{ route('admin.delegates.index') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i></a>
                    </h5>
                </div>
                @if($delegate)
                    <div class="d-flex gap-2">
                        <div class="mt-4">
                            <form action="{{ route('admin.delegates.delegate_daily_delivery_statement',['delegate' => $delegate->id]) }}" method="POST">
                                @csrf 
                                @method('POST')
                                <button type="submit" class="btn btn-primary" @if ($is_disable_1st_btn) disabled @endif> 
                                    كشف تسليم مندوب
                                </button>
                            </form>     
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('admin.delegates.delegate_final_delivery_statement',['delegate' => $delegate->id]) }}" method="POST">
                                @csrf 
                                @method('POST')
                                <button type="submit" class="btn btn-primary" @if ($is_disable_2st_btn) disabled @endif> 
                                    كشف تسليم نهائي
                                </button>
                            </form>     
                        </div>  
                    </div> 
                @endif
                {{-- @if (session()->has('error'))
                    <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
                @endif
                @if (session()->has('success'))
                    <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
                @endif --}}
            </div>
            
            <div class="card-body datatable-container" id="myTabContent">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{ $dataTable->scripts() }}

<script>
   

    $(document).ready(function(){

        const waiting_msg = 'جاري المعالجة'
        const err_msg = 'حدث خطأ في المعالجة'

        $('#express-table').on('change', '.shipment-status-select', function() { 
                var dataTable = $('#express-table').DataTable();
                var columnName = 'id'; // Replace 'columnName' with the actual name of your column
                var columnIndex = dataTable.column(columnName + ':name').index();
                var shipmentId = $(this).closest('tr').find('td:eq('+columnIndex+')').text().trim();

                var shipment_status_id = $("option:selected", this).val();
                var shipment_id = shipmentId

                if (shipment_status_id) {
                    var url = "{{ route('admin.update_shipment_status', ['status' => 'STATUS_PLACEHOLDER','shipment'=> 'SHIPMENT_PLACEHOLDER']) }}";
                    url = url.replace('STATUS_PLACEHOLDER', shipment_status_id);
                    url = url.replace('SHIPMENT_PLACEHOLDER', shipment_id);
                    console.log(url);
                    
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() { 
                            showOverlayWithMessage(waiting_msg);
                            // $('#express-table').prop('disabled', true);
                        },
                        complete: function() {  
                            hideOverlay();
                            // $('#express-table').prop('disabled', false);
                        },
                        success: function(response) {
                            if (response.code == 1) {    
                                dataTable.ajax.reload(null, false); 
                                
                            } else if (response.code == 0) {
                                alert(response.msg);
                            }
                        },
                        error: function() {
                            alert('An error occurred');
                        }
                    });
                }
            });
    });
</script>
@endpush