@extends('admin.layouts.app')
@section('title', 'المستخدمين')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المستخدمين</h5>
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
	              	@foreach($users as $user)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $user->name }}</td>
		                <td>{{ $user->phone }}</td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.admins.edit', $user->id) }}"><i class="fa fa-edit"></i></a>
		                	<a class="btn btn-danger" href="{{ route('admin.admins.destroy', $user->id) }}"  onclick="event.preventDefault();document.getElementById('delete-admin-{{ $user->id }}').submit();"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.admins.destroy', $user->id) }}" method="post" class="d-none"
                                id="delete-admin-{{ $user->id }}">
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
