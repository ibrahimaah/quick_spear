@extends('pages.user.account.index')
@section('active2', 'active')
@section('accountContent')
<h2 class="mb-4">{{ __('Team') }}</h2>
<div class="card">
    @if (session()->has('error'))
        <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    @csrf
    <div class="card-header">
        <h4>{{ __('Add') }}</h4>
    </div>
    <div class="card-body">
        <div class="container">
            <form action="{{ route('front.user.team_store') }}" method="post">
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
                        <label>{{ __('Phone') }}</label><span class="text-danger"> * </span>
                        <input class="form-control mt-2 ml-2" value="{{ old('phone') }}" type="text" name="phone" />
                        @error('phone')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Role') }}</label><span class="text-danger">*</span>
                        <select class="form-control mt-2 ml-2" name="role">
                            {{-- @foreach (App\Models\City::get() as $city) --}}
                            <option value="all">All</option>
                            <option value="shipping">shipping</option>
                            <option value="payments">payments</option>
                            {{-- @endforeach --}}
                        </select>
                        @error('role')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Email') }}</label><span class="text-danger"> * </span>
                        <input class="form-control mt-2 ml-2" value="{{ old('email') }}" type="text" name="email">
                        @error('email')
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
                            <h5>{{ __('team') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Roles') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  @dd($teames)  --}}
                                        @foreach($teams as $team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->phone }}</td>
                                            <td>{{ $team->email }}</td>
                                            <td>{{ $team->role }}</td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" href="{{ route('front.user.team_delete', $team->id) }}">
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
