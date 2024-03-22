@extends('admin.layouts.app')
@section('title', 'المدفوعات')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>طلبات الدفع</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    
                                    <th>شحنات الطلب</th>
                                    <th>التاريخ</th>
                                    <th>عدد الشحنات</th>
                                    <th>المستخدم</th>
                                    <th>طريقة الدفع</th>
                                    <th> المبالغ المراد تحويلها</th>
                                    <th>صرف اجور النقل</th>
                                    <th>الحالة</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        
                                        <td>
                                            <a class="btn btn-success"
                                                href="{{ route('admin.transactions.show', $request->transaction_id) }}">عرض</a>
                                        </td>
                                        <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                        @php
                                      $awb = [];
                                      $tran = App\Models\Transaction::find($request->transaction_id);
                                      foreach ($tran->imports as $im) {
                                         $awb[] = $im->AWB;
                                       }
                                       $ships = App\Models\Shipment::whereIn('shipmentID', $awb);
                                        @endphp
                                        <td>{{ $ships->count() }}</td>
                                        <td>{{ $request->user->name ?? '' }}</td>
                                        <td>
                                            {{ $request->paymentMethod->name ?? '' }} <br />
                                            {{ $request->paymentMethod->provider ?? '' }} <br />
                                            {{ $request->paymentMethod->iban_or_number ?? '' }}
                                        </td>
                                        <td>{{ ($ships->sum('cash_on_delivery_amount') - $ships->sum('collect_amount')) ?? 0 }}</td>
                                        <td>{{ $ships->sum('collect_amount') ?? 0 }}</td>
                                        <td>{{ $request->status == 1 ? 'تم الدفع' : 'جاري المراجعه' }}</td>

                                        <td>
                                            <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editrequest_{{ $request->status . '_' . $request->id }}">تحديث</button>
                                                {{-- <a class="btn btn-success" href="{{ route('admin.requests.show', $request->id) }}">عرض</a> --}}

                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editrequest_{{ $request->status . '_' . $request->id }}"
                                        tabindex="-1"
                                        aria-labelledby="editrequest_{{ $request->status . '_' . $request->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editrequest_{{ $request->status . '_' . $request->id }}Label">
                                                        تعديل الحالة</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('admin.requests.update', $request->id) }}" enctype="multipart/form-data" >
                                                    @csrf
                                                    {{-- @method('put') --}}
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">صورة الايصال</label>
                                                                <input class="form-control" name="photo" type="file">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text" class="col-form-label">الحالة</label>
                                                            <select class="form-control" name="status" id="message-text">
                                                                <option {{ $request->status == 0 ? 'selected' : '' }}
                                                                    value="0">قيد المراجعه</option>
                                                                <option {{ $request->status == 1 ? 'selected' : '' }}
                                                                    value="1">تم الدفع</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-secondary">تحديث</button>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-dismiss="modal">اغلاق</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  --}}
