@extends('admin.layouts.app')
@section('title', 'المستخدمين')
@section('content')



<div class="row mt-5">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>الشحنات</h5>
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
@endpush