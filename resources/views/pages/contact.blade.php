@extends('layouts.app')
@section('title', 'الرئيسية')
@section('content')

<div class="col-12 p-0">
    <div class=" p-0 container">
        <div class="col-12 p-2 p-lg-3 row">
            <div class="col-12 px-2 pt-5 pb-3">
                <div class="col-12 p-0 font-4">
                    <span class="start-head">
                        {{ __('Contact us') }}
                        </span>
                </div>
            </div>
            <div class="col-12 col-lg-8 p-0 ">
                @if (session()->has('error'))
                <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
                @endif
                @if (session()->has('success'))
                    <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
                @endif
                <div style="max-width: 100%;text-align: justify;" class="mx-auto p-0 font-2 naskh">
                    <form class="" method="POST" action="{{route('front.contact-post')}}" id="contact-form">
                        <input type="hidden" name="recaptcha" id="recaptcha">
                        @csrf
                        <div class="col-12 px-0 py-3">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control rounded-0" placeholder="{{ __('Name') }}" required="" min="3" max="255" value="">
                            </div>
                        </div>
                        <div class="col-12 px-0 py-3">
                            <div class="col-12">
                                <input type="email" name="email" class="form-control rounded-0" placeholder="{{ __('Email') }}" required="" value="">
                            </div>
                        </div>
                        <div class="col-12 px-0 py-3">
                            <div class="col-12">
                                <input type="text" name="phone" class="form-control rounded-0" placeholder="{{ __('Phone') }}" required="" min="99999" max="9999999999999999" value="">
                            </div>
                        </div>
                        <div class="col-12 px-0 py-3">
                            <div class="col-12">
                                <textarea class="form-control rounded-0" name="message" style="min-height:200px" placeholder="{{ __('Message') }}" required="" minlength="3" maxlength="1000"></textarea>
                            </div>
                        </div>
                        <div class="col-12 px-0 py-3">
                            <div class="col-12">
                                <button class="btn btn-success rounded-0" type="submit" >{{ __('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
