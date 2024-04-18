@extends('admin.layouts.app')
@section('title', 'الشحنات')
@section('content')
    {{-- <a class="btn btn-primary mb-3" href="{{ route('admin.import_shipments.create') }}">استيراد من ملف اكسيل</a>
    <a class="btn btn-success mb-3" href="{{ asset('assets/file.xlsx') }}">نموذج اكسيل المطلوب</a> --}}
    <button class="btn btn-success mb-3" type="button" data-bs-toggle="modal"
    data-bs-target="#exampleModal">استيراد اكسيل </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.shipment.export') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Type') }}</label>
                            <select name="fileType" class="form-control" id="recipient-name">
                                <option value="pdf">pdf</option>
                                <option value="xlsx">xlsx</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{ __('From') }}</label>
                            <input type="date" name="from" class="form-control" id="message-text">
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                            <input type="date" name="to" class="form-control" id="message-text">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{ __('Action Status') }}</label>
                            <select name="acstatus" class="form-control" id="">
                                <option value="">{{ __('All') }}</option>
                                <option value="0">{{ __('New') }}</option>
                                <option value="1">{{ __('Processing') }}</option>
                                <option value="2">{{ __('Delivered') }}</option>
                                <option value="3">{{ __('Returned') }}</option>
                                <option value="4">{{ __('Pending Payments') }}</option>
                                <option value="5">{{ __('Payment Successful') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>الشحنات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush
    
@endsection
