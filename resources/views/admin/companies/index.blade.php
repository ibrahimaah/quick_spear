@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>الشركات</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>الاسم</th>
	                <th>الصورة</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($companies as $company)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $company->name }}</td>
		                <td><img width="70" src="{{ asset($company->photo) }}" alt="{{ $company->name }}" /></td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.companies.edit', $company->id) }}"><i class="fa fa-edit"></i></a>		                	
		                	<a class="btn btn-danger" href="{{ route('admin.companies.destroy', $company->id) }}"  onclick="event.preventDefault();document.getElementById('delete-company-{{ $company->id }}').submit();"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" method="post" class="d-none"
                                id="delete-company-{{ $company->id }}">
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
