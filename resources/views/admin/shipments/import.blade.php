@extends('admin.layouts.app')
@section('title', 'الشحنات')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @if (session()->has('error'))
        <div class="text-center py-4 text-light my-3 bg-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-center py-4 text-light my-3 bg-success">{{ session()->get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
        <h5>استيراد</h5>
        </div>
        <form class="form theme-form" method="POST" action="{{ route('front.shipments_import') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الملف</label>
                <div class="col-sm-9">
                    <input class="form-control @error('importFile') is-invalid @enderror" name="importFile" type="file">
                    @error('importFile')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">المستخدم</label>
                <div class="col-sm-9">
                    <select class="js-example-basic-single form-control @error('user_id') is-invalid @enderror" name="user_id">
                    <option value="" selected>اختار ...</option>
                    @forelse (App\Models\User::get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @empty
                        لا يوجد مستخدمين حاليا
                    @endforelse
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
        </div>
        </form>
    </div>
    </div>
</div>
@endsection
