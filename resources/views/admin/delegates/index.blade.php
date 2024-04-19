@extends('admin.layouts.app')
@section('title', 'المندوبين')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المندوبين</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>الاسم</th>
	                <th>رقم الهاتف</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($delegates as $delegate)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $delegate->name }}</td>
		                <td>{{ $delegate->phone }}</td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.delegates.edit', $delegate->id) }}"><i class="fa fa-edit"></i></a>
		                	<a class="btn btn-danger" href="{{ route('admin.delegates.destroy', $delegate->id) }}"  onclick="event.preventDefault();document.getElementById('delete-admin-{{ $delegate->id }}').submit();"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.delegates.destroy', $delegate->id) }}" method="post" class="d-none">
                                @csrf
                                @method('delete')
                            </form>

							<a class="btn btn-primary" href="{{ route('admin.delegates.get_shipments', ['delegate'=>$delegate->id]) }}">
								عرض الشحنات
							</a>
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
