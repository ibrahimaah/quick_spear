@extends('pages.user.account.index')
@section('active4', 'active')
@section('accountContent')
<h2 class="mb-4">{{ __('Payment Method') }}</h2>
<div class="card">
    @csrf
    <div class="card-header">
        <h4>{{ __('Add') }} {{ __('Payment Method') }}</h4>
    </div>
    <div class="card-body">
        <div class="container">
            @if (session()->has('error'))
                <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
            @endif
            @if (session()->has('success'))
                <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
            @endif
            <form action="{{ route('front.user.payment_method_store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Name') }}</label><span class="text-danger"> * </span>
                        <input class="form-control mt-2 ml-2" value="{{ old('name') }}" type="text" name="name" />
                        @error('name')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        @php
                            $providers = ["Arab Bank","Jordan Commercial Bank","Housing Bank for Trade &amp; Finance","Cairo Amman Bank","Arab Jordan Investment Bank","Bank al Etihad","BLOM Bank","Bank Audi","Islamic International Arab Bank","Al-Rajhi Bank","Capital Bank of Jordan","Jordan Ahli Bank","INVESTBANK","Bank of Jordan","Jordan Islamic Bank","Safwa Islamic Bank","Jordan Kuwait Bank","Zain Cash","Orange Money","Umniah Mahfazti","MEPS","Mared","Dinarak","CliQ"];
                        @endphp
                        <label>{{ __('Provider') }}</label><span class="text-danger"> * </span>
                        <select class="form-control mt-2 ml-2" name="provider">
                            @foreach ($providers as $provider)
                                <option value="{{ $provider }}">{{ $provider }}</option>
                            @endforeach

                        </select>
                        @error('provider')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>IBAN/{{ __('Wallet') }}</label><span class="text-danger"> * </span>
                        <input class="form-control mt-2 ml-2" value="{{ old('iban_or_number') }}" type="text" name="iban_or_number" />
                        @error('iban_or_number')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-header">
                    <button class="btn btn-primary" type="submit">{{ __('Add') }}</button>
                </div>
            </form>
            <hr />
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Payment Method') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Provider') }}</th>
                                            <th>IBAN/{{ __('Wallet') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  @dd($addresses)  --}}
                                        @foreach($payment_methods as $payment_method)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment_method->name }}</td>
                                            <td>{{ $payment_method->provider }}</td>
                                            <td>{{ $payment_method->iban_or_number }}</td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" href="{{ route('front.user.payment_method_delete', $payment_method->id) }}">
                                                    <i class="bi bi-trash"></i>
                                                    {{ __('Delete') }}
                                                </a>
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
    </div>
</div>
@endsection
