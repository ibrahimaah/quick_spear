@extends('layouts.app')
@section('content')
<div class="container pt-3">
    <!-- ======= Services Section ======= -->
    <section id="services" class="row services">
        <div class="container">
            <div class="row">
                <div class="col-md-6 py-5">
                    <h1 class="text-dark my-4 fw-bold"
                        style="font-size: calc(1.7rem + 1.6901vw - 6.33788px);line-heightv: calc(1.7rem + 2.2535vw - 8.45062px);">
                        {{ __('The best and fastest way to deliver your shipments in simple steps') }}
                    </h1>
                    @if (auth()->check())
                    <a href="{{ route('front.user.account') }}" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Profile') }}</a>
                    @else
                    {{-- <a href="{{ route('front.get_register') }}" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Register') }}</a> --}}
                    @endif
                    {{-- <a class="btn btn-primary py-3 px-5 btn-lg" href="#">اشحن لمرة واحدة</a> --}}
                </div>
                <div class="col-md-6 mt-4 mt-lg-0">
                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active mr-2 tabtitle activeTab" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="46" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-truck">
                                    <path
                                        d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                    </path>
                                </svg>
                                <span class="ml-1 mr-1">{{ __('Local Shipping') }}</span></a>
                            </button>
                        </li>
             
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @if (session()->has('value'))
                                <div class="text-center font-4 mt-4">
                                    {{ session()->get('value') }} (JOD)
                                </div>
                            @endif
                            <form class="my-4" action="{{ route('front.sumExpress') }}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('From') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="city_from"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('City') }}</option>
                                            @foreach (App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('To') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="city_to"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('City') }}</option>
                                            @foreach (App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('Weight') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="wighte"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('Weight') }}</option>
                                            <option value="10" class="text-muted py-3 my-3" style="font-size:14px">
                                                <span>5 (KG)</option>
                                            @for($w = 5; $w <= 100; $w+=5)
                                                <option value="{{ $w+5 }}" class="text-muted p-3" style="font-size:14px">{{ $w }} (KG) - {{ $w+5 }} (KG)</option>
                                            @endfor
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center my-5">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade text-center py-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <a href="{{ route('front.contact') }}" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Contact us') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Services Section -->
</div>
@endsection
