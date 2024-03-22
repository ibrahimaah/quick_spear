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
                    <h2>{{ __('Reset Password') }}</h2>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form action="{{ route('front.forgetPassword.post') }}" method="post">
                            @csrf
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="email" id="email"
                                    placeholder=" البريد الالكتروني" required />
                            </div>
                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3 btn-primary">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-8 m-2" style="background:url('/assets/img/portfolio/portfolio-1.jpg')"></div> --}}
        </div>
    </section>
@endsection
