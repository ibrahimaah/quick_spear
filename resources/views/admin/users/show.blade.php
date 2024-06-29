@extends('admin.layouts.app')
@section('title', 'المستخدمين')
@section('content')


    <ul class="nav nav-pills mb-3 p-4" id="pills-tab" role="tablist">
        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link active" id="pills-account-info-tab" data-bs-toggle="pill"
                data-bs-target="#pills-account-info" role="tab">البيانات الاساسية</a>
        </li>
        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link" id="pills-shipping-tab" data-bs-toggle="pill"
                data-bs-target="#pills-shipping" role="tab">الشحن
                {{-- ({{ $user->shipments->count() }})</a> --}}
        </li>
      
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-account-info" role="tabpanel">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card-header">
                                <h4>معلومات الحساب</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 my-2 col-md-4">
                                            <label>رقم الحساب</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->ACCOUNT_NUMBER() }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>الدولة</label>
                                            <p class="card-text text-secondary">
                                                الاردن
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>العملة</label>
                                            <p class="card-text text-secondary">
                                                JOD
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>نوع الحساب</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->type ?? 'شخصي' }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>رقم الهاتف</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->phone }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>البريد الإلكتروني</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-12 my-2 col-md-4">
                                            <label>اسم المتجر</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->shop->name }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>المدينة</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->shop->city->name }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>المنطقة</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->shop->region }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>الوصف</label>
                                            <p class="card-text text-secondary">
                                                {{ $user->shop->description }}
                                            </p>
                                        </div>
                                       
                                    </div>
                                    <hr />
                                {{--
                                    <div class="row">
                                        <div class="col-12 my-2 col-md-4">
                                            <label>الاسم</label><span class="text-danger">*</span>
                                            <input class="form-control mt-2 ml-2" type="text" value="{{ $user->name }}"
                                                name="name" />
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>رقم الهاتف</label><span class="text-danger">*</span>
                                            <input class="form-control mt-2 ml-2" type="text" value="{{ $user->phone }}"
                                                name="phone" />
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>البريد الالكتروني</label><span class="text-danger">*</span>
                                            <input class="form-control mt-2 ml-2" type="text"
                                                value="{{ $user->email }}" name="email" />
                                        </div>
                                    </div> 
                                --}}
                                </div>
                            </div>
                            <div class="card-header">
                                {{-- <button class="btn btn-primary" type="submit">تحديث</button> --}}
                                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">رجوع</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>الشحنات</h5>
                        </div>
                        <div class="card-body datatable-container" id="myTabContent">
                                {{-- {{ $dataTable->table() }} --}}
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>اسعار الشحن لهذا المستخدم</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border table-sm scroll-horizontal basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المدينة (من)</th>
                                            <th>المدينة (إلى)</th>
                                            <th>التكلفة</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <tr>
                                                <td>1</td>
                                                <td>دمشق</td>
                                                <td>حلب</td>
                                                <td>100</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#edit-rate2-1">
                                                        تعديل
                                                    </button>

                                                    <div class="modal fade" id="edit-rate2-1"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post"
                                                                    action="{{ route('admin.cities.add_rate') }}">
                                                                    @csrf
                                                                    <input type="hidden" value=""
                                                                        name="from">
                                                                    <input type="hidden" value=""
                                                                        name="to">
                                                                    <input type="hidden" value=""
                                                                        name="user_id">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            تعديل</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3 row">
                                                                            <label class="col-sm-3 col-form-label"
                                                                                for="exampleFormControlInput1">تكلفة
                                                                                الشحن</label>
                                                                            <div class="col-sm-9">
                                                                                <input
                                                                                    class="form-control @error('rate') is-invalid @enderror"
                                                                                    name="rate"
                                                                                    id="exampleFormControlInput1"
                                                                                    type="text"
                                                                                    value="">
                                                                                @error('rate')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">إغلاق</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">اضافة</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a class="btn btn-danger" href="#"
                                                        onclick="event.preventDefault();document.getElementById('delete-rate-1').submit();"><i
                                                            class="fa fa-trash"></i></a>
                                                    <form action=""
                                                        method="post" class="d-none"
                                                        id="delete-rate-1">
                                                        @csrf
                                                        {{--  @method('delete')  --}}
                                                    </form>
                                                </td>
                                            </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
   
    </div>
    @push('scripts')
    {{-- {{ $dataTable->scripts() }} --}}
    @endpush
@endsection
