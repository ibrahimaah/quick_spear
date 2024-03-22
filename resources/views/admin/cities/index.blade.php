@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المدن</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>الاسم</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($cities as $city)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $city->name }}</td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.cities.edit', $city->id) }}"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-info" href="{{ route('admin.cities.rates', $city->id) }}">اسعار الشحن</a>
		                	
                                <a class="btn btn-info" href="javascript:void(0)"  onclick="return confirm('Are you sure of deleting this city ?') ? document.getElementById('delete-city-{{ $city->id }}').submit() : '';"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.cities.destroy', $city->id) }}" method="post" class="d-none"
                                id="delete-city-{{ $city->id }}">
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
