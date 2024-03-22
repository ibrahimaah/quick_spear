@extends('admin.layouts.app')
@section('title', 'الاقسام')
@section('content')

<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>الاقسام</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>الاسم</th>
	                <th>القسم</th>
	                <th>الشركة المصنعة</th>
	                <th>وصف</th>
	                <th>الصورة</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($products as $product)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $product->name }}</td>
		                <td>{{ $product->category->name }}</td>
		                <td>{{ $product->company_made }}</td>
		                <td>{{ $product->desc }}</td>
		                <td><img width="70" src="{{ asset(explode(',' ,$product->photo)[0]) }}" alt="{{ $product->name }}" /></td>
		                <td>
		                	<a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}"><i class="fa fa-edit"></i></a>
		                	<a class="btn btn-danger" href="{{ route('admin.products.destroy', $product->id) }}"  onclick="event.preventDefault();document.getElementById('delete-product-{{ $product->id }}').submit();"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="d-none"
                                id="delete-product-{{ $product->id }}">
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
