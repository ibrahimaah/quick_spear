@extends('pages.user.account.index')
@section('active1', 'active')
@section('accountContent')
<h2 class="mb-4">{{ __('Account Details') }}</h2>
<div class="card">
    @if (auth('team')->check())
    <form action="{{ route('front.user.account_update') }}" method="post">
        @csrf
        <div class="card-header">
            <h4>{{ __('Account Informations') }}</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Account Number') }}</label>
                        <p class="card-text">
                            {{ auth('team')->user()->team->ACCOUNT_NUMBER() }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Country') }}</label>
                        <p class="card-text">
                            {{ __('Jordan') }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Currency') }}</label>
                        <p class="card-text">
                            JOD
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Account Type') }}</label>
                        <p class="card-text">
                            {{ auth('team')->user()->team->type ?? '' }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label>
                        <p class="card-text">
                            {{ auth('team')->user()->team->phone }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Email Address') }}</label>
                        <p class="card-text">
                            {{ auth('team')->user()->team->email }}
                        </p>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Name') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth('team')->user()->team->name }}"
                            name="name" />
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth('team')->user()->team->phone }}"
                            name="phone" />
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Email Address') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth('team')->user()->team->email }}"
                            name="email" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">
            <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
        </div>
    </form>
    @else
    <form action="{{ route('front.user.account_update') }}" method="post">
        @csrf
        <div class="card-header">
            <h4>{{ __('Account Informations') }}</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Account Number') }}</label>
                        <p class="card-text">
                            {{ auth()->user()->ACCOUNT_NUMBER() }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Country') }}</label>
                        <p class="card-text">
                            {{ __('Jordan') }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Currency') }}</label>
                        <p class="card-text">
                            JOD
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Account Type') }}</label>
                        <p class="card-text">
                            {{ auth()->user()->type ?? '' }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label>
                        <p class="card-text">
                            {{ auth()->user()->phone }}
                        </p>
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Email Address') }}</label>
                        <p class="card-text">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Name') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth()->user()->name }}"
                            name="name" />
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth()->user()->phone }}"
                            name="phone" />
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Email Address') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth()->user()->email }}"
                            name="email" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">
            <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
        </div>
    </form>
    @endif
</div>
<br />
<hr />
<br />
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Editing Orders') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm display" id="basic-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Created.') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--  @dd($orderes)  --}}
                            @foreach($editOrders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->created_at->format('Y - m - d') }}</td>
                                <td>{{ $order->type }}</td>
                                <td><?php echo $order->desc; ?></td>
                                <td>{{ $order->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
