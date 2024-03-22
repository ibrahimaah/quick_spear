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
                    <h2>{{ __('Code') }} - {{ __('Reset Password') }}</h2>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form action="{{ route('front.updatePassword') }}" method="post">
                            @csrf
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <div class="form-group mt-3 row">
                                <input type="text" class="form-control py-3" name="code" placeholder="{{ __('Code') }}" required />
                            </div>


                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password" id="password"
                                    placeholder="{{ __('New Password') }}" required />
                            </div>


                            <div class="form-group mt-3 row">
                                <input type="password" class="form-control py-3" name="password_confirmation" id="password"
                                    placeholder="{{ __('Confirm Password') }}" required />
                            </div>

                            <div class="text-center mt-3 row">
                                <button type="submit"
                                    class="btn btn-block btn-sm btn py-3 btn-primary">{{ __('Confirm') }}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
