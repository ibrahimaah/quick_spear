@extends('pages.user.express.index')

@section('expressContent')
    <div class="row">
        <div class="col-sm-12">
            @if (session()->has('error'))
                <div class="alert text-center py-4 text-light my-3 alert-danger">{{ session()->get('error') }}</div>
            @endif
            @if (session()->has('success'))
                <div class="alert text-center py-4 text-light my-3 alert-success">{{ session()->get('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Excel Import') }}</h5>
                </div>
                <form class="form theme-form" method="POST" action="{{ route('front.shipments_import') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"
                                for="exampleFormControlInput1">{{ __('Choose File') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('importFile') is-invalid @enderror" name="importFile"
                                    type="file">
                                @error('importFile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">{{ __('Apply') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row my-5 py-2">
        <div class="col-sm-12">
            {{-- <form class="form theme-form" method="POST" action="http://137.184.201.226/testupload/"> --}}
                <form class="form theme-form" method="POST" action="{{ route('front.express.store') }}">
                @csrf
                <div id="repeater">
                    @isset($rows)
                        @forelse ($rows as $row)
                            {{-- @dd($row['consignee_name']) --}}
                            <div class="items my-2" data-group="shipments">
                                <!-- Repeater Content -->
                                <div class="item-content">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>#{{ $loop->iteration }}</h5>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="d-lg-flex flex-row col-sm-12 mb-3 justify-content-center">
                                                    <div class="col-xl-5 col-sm-12 col-lg-7 px-0 mb-2">
                                                        <label>{{ __('Shipper') }}</label><span class="text-danger">*</span>
                                                        <select class="form-control mt-2 ml-2 " data-name="shipper">

                                                            @foreach (auth()->user()->addresses->all() as $address)
                                                                @if ($row['address2'] && $row['address2']->id == $address->id)
                                                                    <option
                                                                        {{ $row['address2']->id ?? 0 == $address->id ? 'selected' : '' }}
                                                                        value="{{ $address->id }}">
                                                                        {{ $address->name }}
                                                                    </option>
                                                                    @else
                                                                    <option
                                                                        {{ $row['address2']->id ?? 0 == $address->id ? 'selected' : '' }}
                                                                        value="{{ $address->id }}">
                                                                        {{ $address->name }}
                                                                    </option>
                                                                    @endif
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <a href="{{ route('front.user.address') }}"
                                                        style="height: 37px;margin-top: 3.3% !important;"
                                                        class="btn btn-primary ml-xl-3 mr-xl-3 mx-3">{{ __('New Address') }}</a>
                                                    <div
                                                        class="col-xl-5 col-sm-12 col-lg-3
                                                px-0 px-sm-0
                                                mb-2
                                                ml-xl-3
                                                mt-2 mt-lg-0">
                                                        <label>{{ __('Provider') }}</label><span class="text-danger">*</span>
                                                        <select class="form-control mt-2" data-name="provider">
                                                            <option value="aramex" selected>Aramex</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                            <div class="row">
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Consignee Name') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" value="{{ $row['consignee_name'] }}"
                                                        type="text" data-name="consignee_name" />
                                                    @error('consignee_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="consignee_phone" value="{{ $row['phone_number'] }}" />
                                                    @error('consignee_phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Phone') }} 2</label>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="consignee_cell_phone"
                                                        value="{{ $row['secondary_phone_number'] }}" />
                                                    @error('consignee_cell_phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('City') }}</label><span class="text-danger">*</span>
                                                    <select class="form-control mt-2 ml-2" type="text"
                                                        data-name="consignee_city">
                                                        @foreach (App\Models\City::get() as $city)
                                                            <option {{ $row['city1']->id == $city->id ? 'selected' : '' }}
                                                                value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('consignee_city')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Region') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="consignee_line2" value="{{ $row['area'] }}" />
                                                    @error('consignee_line2')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Description') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="consignee_line1" value="{{ $row['detailed_address'] }}" />
                                                    @error('consignee_line1')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Weight') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text" data-name="weight"
                                                        value="{{ $row['weight'] ?? '' }}" />
                                                    @error('weight')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Contents') }}</label><span class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="description" value="{{ $row['shipment_content'] }}" />
                                                    @error('description')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Comments') }}</label>
                                                    <input class="form-control mt-2 ml-2" type="text" data-name="comments"
                                                        value="{{ $row['notes'] }}" />
                                                    @error('comments')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Reference') }}</label>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        value="{{ auth()->user()->ACCOUNT_NUMBER() ??auth('team')->user()->team->ACCOUNT_NUMBER() }}"
                                                        data-name="reference" />
                                                    @error('reference')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Number OF Pieces') }}</label><span
                                                        class="text-danger">*</span>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="number_of_pieces" value="{{ $row['pieces'] }}" />
                                                    @error('number_of_pieces')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 my-2 col-md-4">
                                                    <label>{{ __('Cash On Delivery') }} (JOD)</label>
                                                    <input class="form-control mt-2 ml-2" type="text"
                                                        data-name="cash_on_delivery_amount" value="{{ $row['cod'] }}" />
                                                    @error('cash_on_delivery_amount')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Repeater Remove Btn -->
                                <div class="repeater-remove-btn">
                                    <button class="btn btn-danger remove-btn">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        @endisset
                    </div>

                    <button type="submit" class="btn btn-success btn-block mx-auto my-5">{{ __('Apply') }}</button>
                </form>
                <!-- Repeater End -->
                {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script>
                   function testShowDate() {
                    let arr = [];

                    $('#repeater > .items').each(function(index) {
                        var object = {'consignee_phone': $('input > #consignee_phone').val()};
                        // $('input').each(function(index){
                            arr.push(object);
                            // arr[] = $('input').val();
                        // });
                    });

                    console.log(arr);
                   }
                </script> --}}
            </div>
        </div>
    @endsection
