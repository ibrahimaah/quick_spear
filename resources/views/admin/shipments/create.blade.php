@extends('admin.layouts.app')
@section('title', 'تحميل اكسل شيت شحنات لمستخدم واحد')
@section('content')
 
<div class="row">
    <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
        <h5>تحميل اكسل شيت مدفوعات</h5>
        </div>
        <form class="form theme-form" method="POST" action="{{ route('admin.import.store') }}" enctype="multipart/form-data">
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
{{-- 
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
            </div> --}}
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">حفظ</button>
        </div>
        </form>
    </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>عرض نتائج عملية رفع الملف</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h6>عرض COD التي يوجد بها اختلاف</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>اسم العميل</th>
                                    <th>رقم الشحنه</th>
                                    <th>COD نظام</th>
                                    <th>COD اكسل</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (json_decode(Session::get('diff'),true) ?? [] as $diff)
                                    <tr>
                                        <td>{{ $diff['consignee_name'] }}</td>
                                        <td>{{ $diff['awb'] }}</td>
                                        <td>{{ $diff['codvalue'] }}</td>
                                        <td>{{ $diff['codvalue_excel'] }}</td>
                                    </tr>

                                @empty
                                <tr>
                                   <span class="text text-info"> لا توجد بيانات</span>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <h6>عرض COD الغير موجود في النظام</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>رقم الشحنه</th>
                                    <th>COD نظام</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (json_decode(Session::get('notFound'),true) ?? [] as $notFound)
                                    <tr>
                                        <td>{{ $notFound['awb'] }}</td>
                                        <td>{{ $notFound['codvalue'] }}</td>
                                    </tr>

                                @empty
                                <tr>
                                   <span class="text text-info"> لا توجد بيانات</span>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <h6>عرض COD المتكرر </h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>اسم العميل</th>
                                    <th>رقم الشحنه</th>
                                    <th>COD نظام</th>
                                    <th>COD اكسل</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (json_decode(Session::get('repeat'),true) ?? [] as $repeat)
                                    <tr>
                                        <td>{{ $repeat['consignee_name'] }}</td>
                                        <td>{{ $repeat['awb'] }}</td>
                                        <td>{{ $repeat['codvalue'] }}</td>
                                        <td>{{ $repeat['codvalue_excel'] }}</td>
                                    </tr>

                                @empty
                                <tr>
                                   <span class="text text-info"> لا توجد بيانات</span>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
