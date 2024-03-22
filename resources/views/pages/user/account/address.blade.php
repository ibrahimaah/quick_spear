@extends('pages.user.account.index')
@section('active6', 'active')
@section('accountContent')
    <h2 class="mb-4">{{ __('Address') }}</h2>
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
                <form action="{{ route('front.user.address_store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 my-2 col-md-4">
                            <label>{{ __('Name') }}</label><span class="text-danger"> * </span>
                            <input class="form-control mt-2 ml-2" value="{{ old('name') }}" type="text"
                                name="name" />
                            @error('name')
                                <span class="text-danger text-center p-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 my-2 col-md-4">
                            <label>{{ __('Phone') }}</label><span class="text-danger"> * </span>
                            <input class="form-control mt-2 ml-2" value="{{ old('phone') }}"
                                   type="text" 
                                   id="phone_number_"
                                   pattern="[0-9]{10}" 
                                   onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                   name="phone" 
                                   title="Please Enter Ten Digits"
                            />
                            @error('phone')
                                <span class="text-danger text-center p-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 my-2 col-md-4">
                            <label>{{ __('City') }}</label><span class="text-danger">*</span>
                            <select class="form-control mt-2 ml-2" type="text" name="city">
                                @foreach (App\Models\City::get() as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city')
                                <span class="text-danger text-center p-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 my-2 col-md-4">
                            <label>{{ __('Region') }}</label><span class="text-danger"> * </span>
                            <input class="form-control mt-2 ml-2" value="{{ old('region') }}" type="text"
                                name="region" />
                            @error('region')
                                <span class="text-danger text-center p-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 my-2 col-md-4">
                            <label>{{ __('Description') }}</label><span class="text-danger"> * </span>
                            <input class="form-control mt-2 ml-2" value="{{ old('desc') }}" type="text"
                                name="desc" />
                            @error('desc')
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
                                <h5>{{ __('Address') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm display" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('City') }}</th>
                                                <th>{{ __('Region') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{--  @dd($addresses)  --}}
                                            @foreach ($addresses->where('type', 0) as $address)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $address->name }}</td>
                                                    <td>{{ $address->phone }}</td>
                                                    <td>{{ App\Models\City::where('id', $address->city)->first()->name ?? $address->city }}
                                                    </td>
                                                    <td>{{ $address->region }}</td>
                                                    <td>{{ $address->desc }}</td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm"
                                                            href="{{ route('front.user.address_delete', $address->id) }}">
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

    <script src="{{ asset('assets/vendor/jquery/jquery_v3.7.min.js') }}"></script>
    <script>
         $(()=>{
        $('input[type=text]:not(#phone_number_)').on('keydown',(e)=>{
            if((/\d/g).test(e.key)) e.preventDefault();
        }) 
    });
    </script>
@endsection
