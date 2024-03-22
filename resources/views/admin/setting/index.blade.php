{{-- {{ App\Models\Setting::create(['website_logo' => 'website_logo', 'website_email' => 'website_email', 'website_name' => 'website_name', 'first_char_account_number' => 'SH']) }} --}}
@extends('admin.layouts.app')
@section('title', 'الاعدادات ')
@section('pageTitle', 'الاعدادات ')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>الاعدادات</h5>
            </div>
            <form class="form theme-form" method="POST" action="{{ route('admin.setting.update') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row mb-5">
                        <label class="col-sm-3 col-form-label"> الشعار الحالي</label>
                        <div class="col-sm-9 text-center">
                            <img class="img-fluid" width="420" src="{{ asset($setting->website_logo) }}"
                                alt="{{ $setting->website_name }}" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">الشعار جديد</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('logo') is-invalid @enderror" name="logo" type="file">
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">اسم الموقع</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('website_name') is-invalid @enderror" name="website_name" type="text" value="{{ $setting->website_name }}">
                            @error('website_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">اول حرفين في رقم حساب المستخدم</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('first_char_account_number') is-invalid @enderror" name="first_char_account_number" type="text" value="{{ $setting->first_char_account_number }}">
                            @error('first_char_account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-primary" type="submit">حفظ</button>
    </div>
    </form>
</div>

@endsection
