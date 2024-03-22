@extends('pages.user.payments.master')
@section('active1', 'active')
@section('paymentsContent')

    <h5>{{ __('Payments') }}</h5>
    @if (session()->has('error'))
        <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <h2>اجمالي المدفوعات قيد المراجعه : {{ $transactions->where('status','=', 0)->sum('value') }} </h2>
                    {{-- <h2>اجمالي المصاريف قيد المراجعه : {{ $shipments_rev }} </h2> --}}
                    {{-- <h3></h3> --}}
                    {{-- <a href="#" class="btn btn-success">{{ __('Withdraw') }}</a> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal"
                data-bs-target="#exampleModal">{{ __('Export') }}</button>
            <button type="button" class="btn btn-secondary mb-4" data-bs-toggle="modal"
                data-bs-target="#filter">{{ __('Filter') }}</button>
            <form action="">
                {{-- <form action="{{ route('front.payments.index') }}" method="get"> --}}
                {{-- @csrf --}}
                <div class="row">
                    <div class="col-sm-6">
                        <label for="recipient-name" class="col-form-label">{{ __('Action Status') }}</label>
                        <select name="status" class="form-control" id="recipient-name">
                            <option value="0" selected>اختر</option>
                            <option value="2">{{ __('Processing') }}</option>
                            <option value="1">{{  __('Payment Successful') }}</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" style="margin-top: 38px" class="btn btn-info">{{ __('Apply') }}</button>
                    </div>
                </div>
            </form>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('front.payments.export') }}">
                            <div class="modal-body">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">{{ __('Type') }}</label>
                                    <select name="fileType" class="form-control" id="recipient-name">
                                        <option value="pdf">pdf</option>
                                        <option value="xlsx">xlsx</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">{{ __('From') }}</label>
                                    <input type="date" name="from" class="form-control" id="message-text">
                                </div>

                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                    <input type="date" name="to" class="form-control" id="message-text">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 


            <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="">
                            <div class="modal-body">
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text" class="col-form-label">{{ __('From') }}</label>
                                        <input type="date" name="from" class="form-control" id="message-text">
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                        <input type="date" name="to" class="form-control" id="message-text">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <form action="{{ route('front.payments.checked') }}" id="checkedForm" method="POST"> --}}
                        @csrf
                        {{-- <input type="hidden" name="payment_method_id" value="{{ auth()->user()->paymentMethods->first()->id ?? '' }}"> --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <select name="payment_method_id" id="paymentM" style="display: none"
                                class="form-control">
                                <option value="">{{ __('Payment Method') }}</option>
                                @foreach (auth()->user()->paymentMethods as $paymentMethod)
                                    <option
                                        value="{{ $paymentMethod->id }}">
                                        {{ $paymentMethod->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text text-danger" id="validationPay" style="display: none;">من فضلك اختر وسيلة دفع</small>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="btnSubmit" onclick="doneChecked()" style="display: none"  class="btn btn-sm btn-warning">{{ __('Payment Request') }}</button>

                            </div>
                        </div>
                      
                        
                       
                        <table class="table display table-bordered basic-1" id="hidden-table-info">
                            <thead>
                                <tr>
                                    <th width="50px"><input type="checkbox" onchange="checkes(this)" id="master"></th>
                                    <th>#</th>
                                    <th>{{ __('Created.') }}</th>
                                    <th>{{ __('Value') }} (JOD)</th>
                                    <th>{{ __('Action Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            @if ($transaction->status == 0)
                                            <input type="checkbox" onchange="checkThis(this)" class="sub_chk" name="checked[]" value="{{ $transaction->id }}" data-id="{{ $transaction->id }}">

                                            @endif
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        {{-- <td>{{ $shipments->sum('cash_on_delivery_amount') - ($shipments->sum('collect_amount') ?? 0) }} --}}
                                        <td>{{ $transaction->value ?? 0 }}
                                        </td>
                                        <td>{{ $transaction->status == 1 ? __('Payment Successful') : __('Processing') }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-pill" role="group"
                                                aria-label="Basic example">
                                                <a class="btn btn-success"
                                                    href="{{ route('front.payments.show', $transaction->id) }}">عرض</a>

                                                @if ($transaction->status == 0)
                                                    
                                                @if (\App\Models\PaymentRequest::where('transaction_id', $transaction->id)->count() > 0)
                                                <a class="btn btn-secondary mx-2" href="javascript:void(0)" >تم تقديم طلب الدفع لهذه العمليه</a>
                                                @else
                                                <a class="btn btn-primary mx-2" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#payment_request_zaro{{ $transaction->id }}">{{ __('Payment Request') }}</a>

                                                        <div class="modal fade" id="payment_request_zaro{{ $transaction->id }}" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('front.payments.PaymentRequestSend') }}" id="ze{{ $transaction->id }}">
                                                                        @csrf
                                                                        <input type="hidden" name="transaction_id"
                                                                            value="{{ $transaction->id }}">
                                                                        <div class="modal-body">
                                                                            {{-- @csrf --}}
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-md-12 mb-3">
                                                                                    <label for="message-text"
                                                                                        class="col-form-label">{{ __('Payment Method') }}</label>
                                                                                    <select name="payment_method_id"
                                                                                        class="form-control">
                                                                                        @foreach (auth()->user()->paymentMethods as $paymentMethod)
                                                                                            <option
                                                                                                value="{{ $paymentMethod->id }}">
                                                                                                {{ $paymentMethod->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">{{ __('Apply') }}</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endif


                                                @endif

                                                @if ($transaction->status == 1)
                                                    <a class="btn btn-primary mx-2" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#payment_request{{ $transaction->id }}">{{ __('Payment Information') }}</a>


                                                    <div class="modal fade" id="payment_request{{ $transaction->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('front.payments.PaymentRequestSend') }}" id="paid{{ $transaction->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="transaction_id"
                                                                        value="{{ $transaction->id }}">
                                                                    <div class="modal-body">
                                                                        {{-- @csrf --}}
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-12 mb-3">
                                                                                <label for="message-text"
                                                                                    class="col-form-label">{{ __('Payment Method') }}</label>
                                                                                <select name="payment_method_id"
                                                                                    class="form-control">
                                                                                    @foreach (auth()->user()->paymentMethods as $paymentMethod)
                                                                                        <option
                                                                                            value="{{ $paymentMethod->id }}">
                                                                                            {{ $paymentMethod->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">{{ __('Apply') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                              @if ($transaction->image != 'N/A')  <a href="{{ url($transaction->image) }}" target="_blanck" class="btn btn-info"><span class="text text-warning">$</span></a> @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var master = document.getElementById('master');
        var checkboxes = document.getElementsByName('checked[]');
        var button = document.getElementById('btnSubmit');
        var pay = document.getElementById('paymentM');
            function checkes(elemet)
            {
                if(elemet.checked === true) {
                button.style.display = 'block';
                pay.style.display = 'block';
                checkboxes.forEach(element => {
                    element.checked = true;
                });
                // for (var i = 0; i < checkboxes.length; i++) {
                //     var a = checkboxes[i];
                //     a.checked = true;
                // }
            }else {
                button.style.display = 'none';
                pay.style.display = 'none';
    
                checkboxes.forEach(element => {
                    element.checked = false;
                });
            }
            }
            function checkThis(element)
            {
                if (element.checked == true) {
                    button.style.display = 'block';
                    pay.style.display = 'block';
                }else{
                    button.style.display = 'none';
                    pay.style.display = 'none';
                }
            }

            function doneChecked()
            {
              
                var checks = document.getElementsByName('checked[]');
                var payment_method_id = document.getElementById('paymentM').value;
                var checkArray = [];
                for (var i = 0; i < checks.length; i++) {
                var a = checks[i];
                checkArray.push(a.value);
                }
                if (payment_method_id == "") {
                    document.getElementById('validationPay').style.display = "block";
                    return ;
                }
                var formData = new FormData();
                    formData.append('checked[]', checkArray);
                    formData.append('payment_method_id', payment_method_id);
                var xmlHttp = new XMLHttpRequest();
                    xmlHttp.onreadystatechange = function()
                    {
                        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                        {
                            // alert(xmlHttp.responseText);
                            window.location.href = "{{ route('front.success') }}";
                        }
                    }
                    xmlHttp.open("post", "{{ route('front.payments.checked') }}");
                    xmlHttp.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");
                    xmlHttp.send(formData); 
            }

           
    </script> 
    @push('scripts')
    <script>
        // document.ready(function(){
            // $('#hidden-table-info').DataTable({
            //     columnDefs: [
            //         { orderable: false, targets: 0 }
            //     ]
            // });
        // })
    </script>
    @endpush
@endsection
