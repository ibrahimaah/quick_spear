@extends('pages.user.account.index')
@section('active7', 'active')
@section('accountContent')
<div class="row mt-5">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Shipping Price') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border table-sm scroll-horizontal datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('City') . ' (' . __('From') . ')' }}</th>
                                <th>{{ __('City') . ' (' . __('To') . ')' }}</th>
                                <th>{{ __('Cost') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates->where('user_id', null) as $rate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{ $rate->city_r_from->name }}</td>
                                <td>{{ $rate->city_r_to->name }}</td>
                                <td>{{ $rate->rate }}</td>
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
                <h5>{{ __('Shipping Price For You') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border table-sm scroll-horizontal datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('City') . ' (' . __('From') . ')' }}</th>
                                <th>{{ __('City') . ' (' . __('To') . ')' }}</th>
                                <th>{{ __('Cost') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates->where('user_id', auth()->user()->id) as $rate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{ $rate->city_r_from->name }}</td>
                                <td>{{ $rate->city_r_to->name }}</td>
                                <td>{{ $rate->rate }}</td>
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
