@extends('admin.layouts.app')
@section('title', 'اضافة مستخدم')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات المستخدم</h5>
                  </div>
                  <form class="form theme-form" method="POST" action="{{ route('admin.admins.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('name') is-invalid @enderror" name="name" id="exampleFormControlInput1" value="{{ $user->name }}" type="text" placeholder="الاسم">
                          @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">رقم الهاتف</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" id="exampleFormControlInput1" type="text" placeholder="رقم الهاتف">
                          @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">كلمة المرور</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('password') is-invalid @enderror" name="password" id="exampleFormControlInput1" type="password" placeholder="اترك هذا الحقل فارغ اذا لم ترد التعديل">
                          @error('password')
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
