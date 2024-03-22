@extends('pages.user.account.index')
@section('active5', 'active')
@section('accountContent')
    <h2 class="mb-4">{{ __('Company Delivery') }}</h2>


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <img src="data:image/png;base64,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"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Connect Your account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('front.user.aramex_account_update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Account Number') }}</label>
                            <input type="text" class="form-control" name="AccountNumber" value="{{ $company->AccountNumber ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('User Name') }}</label>
                            <input type="text" class="form-control" name="UserName" value="{{ $company->UserName ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Password') }}</label>
                            <input type="text" class="form-control" name="Password" value="{{ $company->Password ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Account PIN') }}</label>
                            <input type="text" class="form-control" name="AccountPin" value="{{ $company->AccountPin ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Account Entity') }}</label>
                            <input type="text" class="form-control" name="AccountEntity" value="{{ $company->AccountEntity ?? '' }}">
                        </div>


                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Account Country Code') }}</label>
                            <input type="text" class="form-control" name="AccountCountryCode" value="{{ $company->AccountCountryCode ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Version') }}</label>
                            <input type="text" class="form-control" name="Version" value="{{ $company->Version ?? '' }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
