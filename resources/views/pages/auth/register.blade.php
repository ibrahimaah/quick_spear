@extends('layouts.auth')

@section('content')
    <section class="container-fluid pt-4">
        <div class="row justify-content-center px-4 pt-0">
            <div class="col-lg-4">
                <div class="section-title">
                    <h2>إنشاء حساب جديد</h2>
                </div>
                <form action="{{ route('front.register') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <input type="text" data-toggle="tooltip" data-placement="top" title="الاسم يجب ان يكون اكبر من 8 حروف واقل من 30 " name="name" value="{{ old('name') }}" class="form-control py-3 mb-2" id="name" placeholder="الإسم الكامل" required />
                        @error('name')
                            <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                        <span>الاسم يجب ان يكون اكبر من 8 حروف واقل من 30</span>

                    </div>
                    <div class="form-group mt-2 row">
                        <input type="text" value="{{ old('phone') }}" class="form-control py-3" name="phone" id="phone" placeholder="رقم الهاتف" required />
                        @error('phone')
                        <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-3 row">
                        <input type="text" value="{{ old('email') }}" class="form-control py-3" name="email" id="email" placeholder="البريد الالكتروني" required autocomplete="false" />
                        @error('email')
                        <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-3 row">
                        <input type="password" value="{{ old('password') }}" class="form-control py-3" name="password" id="password" placeholder="كلمة المرور" required autocomplete="new-password" />
                        @error('password')
                        <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-3 row">
                        <input type="password" value="{{ old('password_confirmation') }}" class="form-control py-3" name="password_confirmation" id="password_confirmation" placeholder="اعادة كتابة كلمة المرور" required autocomplete="new-password" />
                        @error('password_confirmation')
                        <span class="text-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-center mt-3 row">
                        <button type="submit" class="btn btn-block btn-sm btn py-3
                         btn-primary">إنشاء حساب جديد</button>
                    </div>
                </form>
            </div>
            {{--  <div class="col-lg-8 m-2" style="background:url('/assets/img/portfolio/portfolio-1.jpg')"></div>  --}}
        </div>
    </section>
@endsection
