@extends('admin.layouts.app')
@section('title', 'اضافة مستخدم')
@section('content')


@if(session()->has('error'))
<div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
@endif
@if(session()->has('success_store'))
<div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success_store') }}</div>
@endif

<div class="row">

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>بيانات المستخدم</h5>
      </div>
      <form class="form theme-form" method="POST" action="{{ route('admin.users.store') }}"
        enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">الاسم</label>
            <div class="col-sm-9">
              <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                type="text" placeholder="الاسم" required />
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">رقم الهاتف</label>
            <div class="col-sm-9">
              <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"
                type="text" placeholder="رقم الهاتف" required />
              @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{--
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">المنطقة</label>
            <div class="col-sm-9">
              <input class="form-control @error('region') is-invalid @enderror" name="region"
                value="{{ old('region') }}" type="text" placeholder="المنطقة">
              @error('region')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          --}}

          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">البريد الالكتروني</label>
            <div class="col-sm-9">
              <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                type="email" placeholder="البريد الالكتروني" required />
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">اسم المتجر</label>
            <div class="col-sm-9">
              <input class="form-control @error('shop_name') is-invalid @enderror" name="shop_name"
                value="{{ old('shop_name') }}" type="text" placeholder="اسم المتجر" required />
              @error('shop_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">المدينة</label>
            <div class="col-sm-9">
              <select class="form-control @error('city') is-invalid @enderror" name="city" required>
                @foreach (App\Models\City::get() as $city)
                <option value="{{ $city->id }}" <?=(old('city')==$city->id) ? 'selected' : ''?>>{{ $city->name }}
                </option>
                @endforeach
              </select>
              @error('city')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">المنطقة</label>
            <div class="col-sm-9">
              <input class="form-control @error('region') is-invalid @enderror" name="region"
                value="{{ old('region') }}" type="text" placeholder="المنطقة" required />
              @error('region')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">الوصف</label>
            <div class="col-sm-9">
              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id=""
                cols="30" rows="4" placeholder="الوصف" required>{{ old('description') }}</textarea>
              {{-- <input class="form-control @error('description') is-invalid @enderror" name="description"
                value="{{ old('description') }}" type="text" placeholder="الوصف" required /> --}}
              @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>



          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">كلمة المرور</label>
            <div class="col-sm-9">
              <input class="form-control @error('password') is-invalid @enderror" name="password"
                value="{{ old('password') }}" type="password" placeholder="كلمة المرور" required />
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>


          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">تأكيد كلمة المرور</label>
            <div class="col-sm-9">
              <input class="form-control @error('password_confirmation') is-invalid @enderror"
                name="password_confirmation" value="{{ old('password_confirmation') }}" type="password"
                placeholder="اعادة كتابة كلمة المرور" required />
              @error('password_confirmation')
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