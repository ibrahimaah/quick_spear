@extends('admin.layouts.app')
@section('title', 'المستخدمين')
@section('content')
<style>
    .datatable-container {
        overflow-x: auto;
        white-space: nowrap; /* Prevents text wrapping */
    }
</style>

    <ul class="nav nav-pills mb-3 p-4" id="pills-tab" role="tablist">
        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link active" id="pills-account-info-tab" data-bs-toggle="pill"
                data-bs-target="#pills-account-info" role="tab" aria-controls="pills-account-info"
                aria-selected="true">البيانات الاساسية</a>
        </li>
        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link" id="pills-shipping-tab" data-bs-toggle="pill"
                data-bs-target="#pills-shipping" role="tab" aria-controls="pills-shipping" aria-selected="false">الشحن
                ({{ $user->shipments->count() }})</a>
        </li>
        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link" id="pills-documents-tab" data-bs-toggle="pill"
                data-bs-target="#pills-documents" role="tab" aria-controls="pills-documents"
                aria-selected="false">الوثائق ({{ $documents->count() }})</a>
        </li>

        <li class="nav-item mx-3" role="presentation">
            <a href="#" class="nav-link" id="pills-payments-tab" data-bs-toggle="pill"
                data-bs-target="#pills-payments" role="tab" aria-controls="pills-payments" aria-selected="false">وسائل
                الدفع ({{ $payments->count() }})</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-account-info" role="tabpanel"
            aria-labelledby="pills-account-info-tab">
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
                                            <p class="card-text">
                                                {{ $user->ACCOUNT_NUMBER() }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>الدولة</label>
                                            <p class="card-text">
                                                الاردن
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>العملة</label>
                                            <p class="card-text">
                                                JOD
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>نوع الحساب</label>
                                            <p class="card-text">
                                                {{ $user->type ?? 'شخصي' }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>رقم الهاتف</label>
                                            <p class="card-text">
                                                {{ $user->phone }}
                                            </p>
                                        </div>
                                        <div class="col-12 my-2 col-md-4">
                                            <label>البريد الإلكتروني</label>
                                            <p class="card-text">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr />
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
                                </div>
                            </div>
                            <div class="card-header">
                                <button class="btn btn-primary" type="submit">تحديث</button>
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
                                {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>اسعار الشحن</h5>
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
                                        @foreach ($rates->where('user_id', 0) as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rate->city_r_from->name }}</td>
                                                <td>{{ $rate->city_r_to->name }}</td>
                                                <td>{{ $rate->rate }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#edit-rate-{{ $rate->id }}">
                                                        تعديل لهذا المستخدم
                                                    </button>

                                                    <div class="modal fade" id="edit-rate-{{ $rate->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post"
                                                                    action="{{ route('admin.cities.add_rate') }}">
                                                                    @csrf
                                                                    <input type="hidden" value="{{ $rate->city_from }}"
                                                                        name="from">
                                                                    <input type="hidden" value="{{ $rate->city_to }}"
                                                                        name="to">
                                                                    <input type="hidden" value="{{ $user->id }}"
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
                                                                                    value="{{ $rate->rate }}">
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
                                                        onclick="event.preventDefault();document.getElementById('delete-rate-{{ $rate->id }}').submit();"><i
                                                            class="fa fa-trash"></i></a>
                                                    <form action="{{ route('admin.cities.rate_destroy', $rate->id) }}"
                                                        method="post" class="d-none"
                                                        id="delete-rate-{{ $rate->id }}">
                                                        @csrf
                                                        {{--  @method('delete')  --}}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                                        @foreach ($rates->where('user_id', $user->id) as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rate->city_r_from->name }}</td>
                                                <td>{{ $rate->city_r_to->name }}</td>
                                                <td>{{ $rate->rate }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#edit-rate2-{{ $rate->id }}">
                                                        تعديل
                                                    </button>

                                                    <div class="modal fade" id="edit-rate2-{{ $rate->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post"
                                                                    action="{{ route('admin.cities.add_rate') }}">
                                                                    @csrf
                                                                    <input type="hidden" value="{{ $rate->city_from }}"
                                                                        name="from">
                                                                    <input type="hidden" value="{{ $rate->city_to }}"
                                                                        name="to">
                                                                    <input type="hidden" value="{{ $user->id }}"
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
                                                                                    value="{{ $rate->rate }}">
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
                                                        onclick="event.preventDefault();document.getElementById('delete-rate-{{ $rate->id }}').submit();"><i
                                                            class="fa fa-trash"></i></a>
                                                    <form action="{{ route('admin.cities.rate_destroy', $rate->id) }}"
                                                        method="post" class="d-none"
                                                        id="delete-rate-{{ $rate->id }}">
                                                        @csrf
                                                        {{--  @method('delete')  --}}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
            <div id="documents" class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>الوثائق</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>تم التقديم</th>
                                            <th>النوع</th>
                                            <th>الحالة</th>
                                            <th>الاجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  @dd($addresses)  --}}
                                        @foreach ($documents as $document)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $document->created_at }}</td>
                                                <td>{{ $document->type }}</td>
                                                <td>
                                                    @if ($document->statusVerify == 1)
                                                        <span class="badge bg-success">تم التحقق</span>
                                                    @elseif($document->statusVerify == 2)
                                                        <span class="badge bg-success">تم الرفض</span>
                                                    @else
                                                        <span class="badge bg-success">قيد المراجعه</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#delete-{{ $document->id }}">حذف</button>
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#update-{{ $document->id }}">تحديث الحالة</button>

                                                    <div class="modal fade" id="delete-{{ $document->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.users.documents_delete', $document->id) }}"
                                                                    method="POST">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        هل انت متأكد من المتابعه ؟
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">اغلاق</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">متابعة</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="update-{{ $document->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.users.documents_update', $document->id) }}"
                                                                    method="POST">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <img src="{{ asset($document->document) }}"
                                                                            width="100%" alt="">
                                                                        <div class="form-group">
                                                                            <label for="status"
                                                                                class="col-form-label">الحالة</label>
                                                                            <select name="status" class="form-control"
                                                                                id="status">
                                                                                <option value="0"
                                                                                    {{ $document->statusVerify == 0 ? 'selected' : '' }}>
                                                                                    قيد المراجعة</option>
                                                                                <option value="1"
                                                                                    {{ $document->statusVerify == 1 ? 'selected' : '' }}>
                                                                                    تم التحقق</option>
                                                                                <option value="2"
                                                                                    {{ $document->statusVerify == 2 ? 'selected' : '' }}>
                                                                                    رفض</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">اغلاق</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">متابعة</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--
            <div class="tab-pane fade" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab">
                <div id="documents" class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>وسائل الدفع</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم الحساب</th>
                                                <th>المزود</th>
                                                <th>IBAN/المحفظة</th>
                                                <th>الاجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                            @foreach ($payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $payment->name }}</td>
                                                    <td>{{ $payment->provider }}</td>
                                                    <td>{{ $payment->iban_or_number }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#delete-{{ $payment->id }}">حذف</button>

                                                        <div class="modal fade" id="delete-{{ $payment->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('admin.users.payments_delete', $payment->id) }}"
                                                                        method="POST">
                                                                        <div class="modal-body">
                                                                            @csrf
                                                                            {{-- @method('DELETE') --}}
                                                                            هل انت متأكد من المتابعه ؟
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">اغلاق</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">متابعة</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        --}}
    </div>
    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush
@endsection
