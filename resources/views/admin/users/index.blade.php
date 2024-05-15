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
	                {{-- <th>البريد الالكتروني</th> --}}
					<th>اسم المتجر</th>
					{{--<th>المدينة</th>
					<th>المنطقة</th>
					<th>الوصف</th>--}}
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
		                {{-- <td>{{ $user->email }}</td>--}}
		                <td>{{ $user->shop?->name }}</td>
						{{--
		                <td>{{ $user->shop?->city?->name }}</td>
		                <td>{{ $user->shop?->region }}</td>
		                <td>{{ $user->shop?->description }}</td>--}}
		                <td class="d-flex gap-2">
		                	<a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user->id) }}"><i class="fa fa-edit"></i> </a>
		                	<a class="btn btn-info btn-sm" href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-eye"></i> </a>
		                	<a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirm('Are you sure deleting user ?') ? document.getElementById('del{{ $user->id }}').submit() : '' ;"><i class="fa fa-trash"></i> </a>
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
