@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات المدينة</h5>
                  </div>
                  <form class="form theme-form" method="POST" action="{{ route('admin.cities.update', $city->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">اسم المدينة</label>
                        <div class="col-sm-9">
                          <input value="{{ $city->name }}" class="form-control @error('name') is-invalid @enderror" name="name" id="exampleFormControlInput1" type="text" placeholder="اسم المدينة">
                          @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الحالة</label>
                        <div class="col-sm-9">
                          <select class="form-control @error('status') is-invalid @enderror" name="status" id="exampleFormControlInput1">
                              <option value="1" {{ $city->status == 1 ? 'selected' : '' }}>ظهور</option>
                              <option value="0" {{ $city->status == 0 ? 'selected' : '' }}>اختفاء</option>
                          </select>
                          @error('status')
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
