@extends('admin.layouts.app')
@section('title', 'المستخدمين')
@section('content')

<div class="row mt-5">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>الشحنات</h5>
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