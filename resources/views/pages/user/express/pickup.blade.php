@extends('pages.user.express.index')
@section('active2', 'active')

@section('expressContent')
    <h2 class="mb-4">{{ __('Pickups') }}</h2>
    @if (session()->has('error'))
        <div class="text-center py-4 text-light my-3 bg-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-center py-4 text-light my-3 bg-success">{{ session()->get('success') }}</div>
    @endif

    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
        data-bs-target="#call_aramex">{{ __('Call Aramex') }}</button>

    <div class="modal fade" id="call_aramex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('front.express.call_aramex') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="message-text1" class="col-form-label">{{ __('From') }}</label>
                                <input type="datetime-local" name="start_time" class="form-control" id="message-text1">
                            </div>

                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                <input type="datetime-local" name="end_time" class="form-control" id="message-text">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Shipper') }}</label>
                            <select name="address_id" class="form-control" id="recipient-name">
                                <option value="0">{{ __('Select') }}</option>
                                @foreach (App\Models\Address::where('user_id', auth()->user()->id)->where('type', 0)->latest()->get() as $address)
                                    <option value="{{ $address->id }}">
                                        {{ $address->name }}
                                    </option>
                                @endforeach
                            </select>
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
        <ul class="card-header pb-0 nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                    type="button" role="tab" aria-controls="all" aria-selected="true">{{ __('All') }}
                    ({{ $pickups->count() }})</button>
            </li>
        </ul>
        <div class="card-body tab-content" id="myTabContent">
            <div class="tab-pane fade show rounded-3 active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>{{ __('Reference') }}</th>
                            <th>{{ __('Shipper') }}</th>
                            <th>{{ __('Notes') }}</th>
                            <th>{{ __('Action Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($pickups as $pickup)
                            <tr>
                                <th>{{ $pickup->CollectionDate }}</th>
                                <td>{{ $pickup->reference }}</td>
                                <td>{{ $pickup->shipper }}</td>
                                <td>{{ $pickup->LastStatusDescription }}</td>
                                <td>
                                    @if ($pickup->LastStatus == 'In Progress')
                                        <span class="badge bg-primary">{{ $pickup->LastStatus }}</span>
                                    @elseif ($pickup->LastStatus == 'COLLECTED')
                                        <span class="badge bg-success">{{ $pickup->LastStatus }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $pickup->LastStatus }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
