@extends('admin.layouts.app')
@section('title', 'إضافة بيانات منطقة')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>إضافة بيانات منطقة</h5>
            </div>
            <form class="form theme-form" method="POST" action="{{ route('admin.regions.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">اسم المنطقة</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="اسم المنطقة" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">المدينة (التي تتبع لها المنطقة)</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="city" id="city" required>
                                <option value="">اختر المدينة</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('name')
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
