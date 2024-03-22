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
                        {{-- <table class="table display datatable" id="basic-2">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    
                                    <th>المرسل إليه</th>
                                    <th>رقم الهاتف</th>
                                    
                                    
                                    <th>الحاله</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shipments as $shipment)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $shipment->created_at->format('Y - m - d') }}</th>
                                        
                                        <td>{{ $shipment->consignee_name }}</td>
                                        <td>{{ $shipment->consignee_phone }}</td>
                                        
                                        
                                        <td>
                                            <livewire:shipment-all :shipment="$shipment" :key="$shipment->id" />
                                        </td>
                                        <td>
                                            {{-- 
                                            <a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i
                                                    class="fa fa-edit"></i> تعديل</a>
                                            <a class="" href="{{ route('admin.shipments.show', $shipment->id) }}"><i
                                                    class="fa fa-eye"></i> عرض</a> 
                                            --}}
                                            {{-- <a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i
                                                    class="fa fa-trash"></i> حذف</a> -}
                                                <a onclick="confirm('برجاء تأكيد الحذف') ? document.getElementById('des{{ $shipment->id }}').submit() : '';" style="color: #f73164; cursor: pointer"><i class="fa fa-trash"></i> حذف</a>
                                                <form action="{{ route('admin.shipments.destroy', $shipment->id) }}" id="des{{ $shipment->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        {{-- <div class="pagination-wrapper">
                            {{ $shipments->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="pagination col-12 p-3">
            {{ $shipments->appends(request()->query())->render() }}
        </div> --}}
    </div>
    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush
    
@endsection
