@extends('pages.user.express.index')
@section('active1', 'active')

@section('expressContent')
<style>
    .datatable-container {
        overflow-x: auto;
        white-space: nowrap; /* Prevents text wrapping */
    }
</style>

    {{-- <h2 class="mb-4">{{ __('Local Shipping') }}</h2> --}}
    <h2 class="mb-4"> الشحنات </h2>
    @if (session()->has('error'))
        <div class="text-center py-4 text-light my-3 bg-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-center py-4 text-light my-3 bg-success">{{ session()->get('success') }}</div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ route('front.express.create') }}">{{ __('Create') }}</a>
    
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
   

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() 
    {

        var dataTable = $('#express-table').DataTable();
        
        $('#shipment_status_select').on('change',function(){
            var columnName = 'status'; // Replace 'columnName' with the actual name of your column
            var columnIndex = dataTable.column(columnName + ':name').index();
            dataTable.column(columnIndex).search($(this).val()).draw()
        })
        
    });

</script>
@endpush 
