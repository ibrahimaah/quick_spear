@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>اسعار الشحن للمدينة ({{ $city->name }})</h5>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                إضافة
            </button>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{--  <th>المدينة (من)</th>  --}}
                                <th>المدينة (إلى)</th>
                                <th>التكلفة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{--  <td>{{ $rate->city_r_from->name }}</td>  --}}
                                <td>{{ $rate->city_to == $city->id ? $rate->city_r_from->name : $rate->city_r_to->name }}</td>
                                <td>{{ $rate->rate }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-rate-{{ $rate->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <div class="modal fade" id="edit-rate-{{ $rate->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('admin.cities.update_rate', $rate->id) }}">
                                                    @csrf
                                                    <input type="hidden" value="{{ $rate->id }}" name="from">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">اضافة</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3 row">
                                                            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">المدينة (إلى)</label>
                                                            <div class="col-sm-9">
                                                                <input readonly class="form-control" value="{{ $rate->city_to == $city->id ? $rate->city_r_from->name : $rate->city_r_to->name }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">تكلفة الشحن</label>
                                                            <div class="col-sm-9">
                                                                <input class="form-control @error('rate') is-invalid @enderror" name="rate"
                                                                    id="exampleFormControlInput1" type="text" value="{{ $rate->rate }}">
                                                                @error('rate')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                        <button type="submit" class="btn btn-primary">اضافة</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="btn btn-danger" href="#"
                                        onclick="event.preventDefault();document.getElementById('delete-rate-{{ $rate->id }}').submit();"><i
                                            class="fa fa-trash"></i></a>
                                    <form action="{{ route('admin.cities.rate_destroy', $rate->id) }}" method="post"
                                        class="d-none" id="delete-rate-{{ $rate->id }}">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.cities.add_rate', $city->id) }}">
                @csrf
                <input type="hidden" value="{{ $city->id }}" name="from">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">المدينة (إلى)</label>
                        <div class="col-sm-9">
                            <select class="form-control @error('city_to') is-invalid @enderror" name="to"
                                id="exampleFormControlInput1">
                                <option value="" selected>اختار مدينة</option>
                                @foreach (App\Models\City::where('status', 1)->get() as $s_city)
                                <option value="{{ $s_city->id }}">{{ $s_city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">تكلفة الشحن</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('rate') is-invalid @enderror" name="rate"
                                id="exampleFormControlInput1" type="text">
                            @error('rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="text" name="rate"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">اضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
