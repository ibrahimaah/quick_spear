@extends('admin.layouts.app')
@section('title', 'الطلبات')
@section('pageTitle', 'الطلبات')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>الطلبات</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>النوع</th>
                    <th>الوصف</th>
                    <th>الحاله</th>
                    <th>الاجراءات</th>
	              </tr>
	            </thead>
	              <tbody>
                    @foreach($orders as $order)
                    {{-- @dd($order) --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->created_at->format('Y - m - d') }}</td>
                        <td>{{ $order->type }}</td>
                        <td><?php echo $order->desc; ?></td>
                        <td>{{ __($order->get_status()) }}</td>
		                <td>
                            <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                @if ($order->type == 'تعديل بيانات الحساب الشخصي')
                                <a class="btn btn-outline-success" href="{{ route('admin.users.edit', $order->user_id) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-success" href="{{ route('admin.users.show', $order->user_id) }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a class="btn btn-outline-success" href="{{ route('admin.shipments.edit', $order->shipment_id) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-success" href="{{ route('admin.shipments.show', $order->shipment_id) }}"><i class="fa fa-eye"></i></a>
                                @endif
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $order->status . '_' . $order->id }}">تحديث</button>

                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="editOrder_{{ $order->status . '_' . $order->id }}" tabindex="-1"
                        aria-labelledby="editOrder_{{ $order->status . '_' . $order->id }}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editOrder_{{ $order->status . '_' . $order->id }}Label">{{ __('Editing Orders') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="message-text"
                                                class="col-form-label">الحالة</label>
                                                <select class="form-control" name="status" id="message-text">
                                                    <option {{ $order->status == 0 ? 'selected' : '' }} value="0">قيد المراجعه</option>
                                                    <option {{ $order->status == 1 ? 'selected' : '' }} value="1">تم التحديث</option>
                                                    <option {{ $order->status == 2 ? 'selected' : '' }} value="2">رفض التعديلات</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary">تحديث</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">اغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
		            @endforeach
	          	  </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	</div>
</div>

@endsection
