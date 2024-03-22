@extends('layouts.auth')

@section('content')
    <section class="container-fluid pt-4">
        <div class="row justify-content-center px-4 py-5">
            <div class="col-lg-4">
                <div class="section-title">
                    <h2>تسجيل الدخول</h2>
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">تفعيل الحساب</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="{{ route('front.login') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="email">
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="email" id="email"
                                    placeholder=" البريد الالكتروني" required />
                            </div>

                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password" id="password"
                                    placeholder="كلمة المرور" required />
                            </div>

                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3
                         btn-primary">تسجيل
                                    الدخول</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-8 m-2" style="background:url('/assets/img/portfolio/portfolio-1.jpg')"></div> --}}
        </div>
    </section>
@endsection
