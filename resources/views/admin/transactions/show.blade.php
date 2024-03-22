{{-- @dd($shipments) --}}
@extends('admin.layouts.app')
@section('title', 'المدفوعات')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المدفوعات</h5>
	      </div>

		  <div class="card-header">
	        <h5>المدفوعات</h5>
			<form method="POST" action="{{ route('admin.exportPayment') }}">
			@csrf
			<input type="hidden" name="id" value="{{ $mainId }}">
			
			<div class="row">
				<div class="col-sm-4">
					<label for="recipient-name" class="col-form-label">{{ __('Type') }}</label>
			<select name="fileType" class="form-control" id="recipient-name">
				<option value="pdf">pdf</option>
				<option value="xlsx" selected>xlsx</option>
			</select>
				</div>
				<div class="col-sm-4">
					<button type="submit" style="margin-top: 39px" class="btn btn btn-info">Export</button>

				</div>
			</div>
			</form>
	      </div>

	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="table display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
					<th>التاريخ</th>
	                <th>AWB</th>
	                <th>المرسل</th>
	                <th>المستلم</th>
	                <th>رقم الهاتف</th>
	                <th>المدينة</th>
	                <th>الدفع عند الاستلام</th>
	                <th>المصاريف</th>
	                <th>الباقي</th>
					<th>الحاله</th>
	                <th>الاجراءات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($shipments as $shipment)
		            <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th>{{ $shipment->created_at->format('Y - m - d') }}</th>
                        <td>{{ $shipment->shipmentID }}</td>
                        <td>{{ $shipment->address->name ?? '' }}</td>
                        <td>{{ $shipment->consignee_name }}</td>
                        <td>{{ $shipment->consignee_phone }}</td>
                        <td>{{ App\Models\City::find($shipment->consignee_city)->first()->name ?? '' }}</td>
                        <td>{{ $shipment->cash_on_delivery_amount ?? '0' }}</td>
                        <td>{{ $shipment->collect_amount }}</td>
                        <td>{{ $shipment->cash_on_delivery_amount - ($shipment->collect_amount ?? 0) }}</td>
                        {{-- <td>Aramex</td> --}}
                        <td>{{ __($shipment->get_status()) }}</td>
		                {{-- <td>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-edit"></i> تعديل</a>
		                	<a class="" href="{{ route('admin.shipments.show', $shipment->id) }}"><i class="fa fa-eye"></i> عرض</a>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-trash"></i> حذف</a>
		                </td> --}}
		                <td>
                            <a class="btn btn-success" href="{{ route('admin.shipments.show', $shipment->id) }}">عرض</a>
                        </td>
                    </tr>
		            @endforeach
	          	  </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	</div>
</div>

@endsection
{{--  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  --}}
