@extends('layouts.auth')

@section('content')
    <section class="container-fluid pt-4">
        <div class="row justify-content-center px-4 py-5">
            <div class="col-lg-4">
                @if (session()->has('error'))
                    <div class="alert text-center py-4 text-light my-3 alert-danger">{{ session()->get('error') }}</div>
                @endif
                @if (session()->has('success'))
                    <div class="alert text-center py-4 text-light my-3 alert-success">{{ session()->get('success') }}</div>
                @endif
                <div class="section-title">
                    <h2>تسجيل الدخول</h2>
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">{{ __('Phone') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">{{ __('E-Mail Address') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">{{ __('Name') }}</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form action="{{ route('front.login') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="phone">
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="phone" placeholder=" {{ __('Phone') }} " required />
                            </div>

                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password" id="password"
                                    placeholder="{{ __('Password') }}" required />
                            </div>

                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3
                         btn-primary">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="{{ route('front.login') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="email">
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="email" id="email"
                                    placeholder=" {{ __('Email Address') }}" required />
                            </div>

                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password" id="password"
                                    placeholder="{{ __('Password') }}" required />
                            </div>

                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3
                         btn-primary">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <form action="{{ route('front.login') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="name">
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="name" id="email"
                                    placeholder=" {{ __('Name') }} " required />
                            </div>

                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password" id="password"
                                    placeholder="{{ __('Password') }}" required />
                            </div>

                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3
                         btn-primary">{{ __('Login') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
                {{-- <div class="text-center my-3">
                    <a href="{{ route('front.get_register') }}">{{ __('Register') }}</a>
                </div> --}}

                <div class="text-center my-3">
                    <a href="{{ route('front.forgetPassword') }}">{{ __('Forgot Your Password?') }}</a>
                </div>
            </div>
            {{-- <div class="col-lg-8 m-2" style="background:url('/assets/img/portfolio/portfolio-1.jpg')"></div> --}}
        </div>
    </section>
@endsection
