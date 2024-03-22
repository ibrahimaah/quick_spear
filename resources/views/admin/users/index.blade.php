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
	          <table class="table table-sm display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>رقم الحساب</th>
	                <th>الاسم</th>
	                <th>رقم الهاتف</th>
	                <th>البريد الالكتروني</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($users as $user)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $user->ACCOUNT_NUMBER() }}</td>
		                <td>{{ $user->name }}</td>
		                <td>{{ $user->phone }}</td>
		                <td>{{ $user->email }}</td>
		                <td>
		                	<a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user->id) }}"><i class="fa fa-edit"></i> تعديل</a>
		                	<a class="btn btn-info btn-sm" href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-eye"></i> عرض</a>
		                	<a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirm('Are you sure deleting user ?') ? document.getElementById('del{{ $user->id }}').submit() : '' ;"><i class="fa fa-trash"></i> حذف</a>
							<form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="del{{ $user->id }}" style="display: none;">
							@csrf
							@method('DELETE')
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
