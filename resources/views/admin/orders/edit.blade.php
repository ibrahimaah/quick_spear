@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات الطلب</h5>
                  </div>
                  <form class="form theme-form" method="POST" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الكمية</label>
                        <div class="col-sm-9">
                          <input value="{{ $order->amount }}" class="form-control @error('amount') is-invalid @enderror" name="amount" id="exampleFormControlInput1" type="text" placeholder="اسم القسم بالعربية">
                          @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الوحدة</label>
                        <div class="col-sm-9">
                          <input value="{{ $order->unit }}" class="form-control @error('unit') is-invalid @enderror" name="unit" id="exampleFormControlInput1" type="text" placeholder="الاسم بالانجليزية">
                          @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">تفاصيل اخرى</label>
                        <div class="col-sm-9">
                          <input value="{{ $order->desc }}" class="form-control @error('desc') is-invalid @enderror" name="desc" id="exampleFormControlInput1" type="text" placeholder="الاسم باللغة الكردية">
                          @error('desc')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="product">المنتج</label>
                        <div class="col-sm-9">
                          <select class="form-control @error('product') is-invalid @enderror" name="product" required id="product">
                            <option value="" selected>اختار المنتج</option>
                            @foreach($products as $product)
                              <option {{ $order->product_id == $product->id ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                          </select>
                          @error('product')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end">
                      <button class="btn btn-primary" type="submit">حفظ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

@endsection
