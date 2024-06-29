@extends('admin.layouts.app')
@section('title', 'عرض المناطق')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المناطق</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>المنطقة</th>
	                <th>المدينة</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($regions as $region)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $region->name }}</td>
		                <td>{{ $region->city->name }}</td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.regions.edit', $region->id) }}"><i class="fa fa-edit"></i></a>
                            {{-- <a class="btn btn-info" href="{{ route('admin.regions.rates', $region->id) }}">اسعار الشحن</a> --}}
		                	
                                <a class="btn btn-info" href="javascript:void(0)"  onclick="return confirm('هل أنت متأكد أنك تريد الحذف؟') ? document.getElementById('delete-region-{{ $region->id }}').submit() : '';"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.regions.destroy', $region->id) }}" method="post" class="d-none"
                                id="delete-region-{{ $region->id }}">
                                @csrf
                                @method('delete')
                            </form> 
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
