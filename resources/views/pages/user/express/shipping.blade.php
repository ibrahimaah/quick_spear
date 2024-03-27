@extends('pages.user.express.index')
@section('active1', 'active')

@section('expressContent')
    <h2 class="mb-4">{{ __('Local Shipping') }}</h2>
    @if (session()->has('error'))
        <div class="text-center py-4 text-light my-3 bg-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-center py-4 text-light my-3 bg-success">{{ session()->get('success') }}</div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ route('front.express.create') }}">{{ __('Create') }}</a>
    

    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
        data-bs-target="#exampleModal">{{ __('Export') }}</button>

    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
        data-bs-target="#filter">{{ __('Filter') }}</button>

    <button class="btn btn-primary print_all mb-3" type="button" data-bs-toggle="modal"
        data-bs-target="#exampleModalIDs">Print Selected</button>



    <div class="modal fade" id="exampleModalIDs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('front.express.printSelectedBulk') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{ __('Select All Matching') }}</label>
                            <input type="text" value="" readonly name="count" class="form-control"
                                id="IDsSelected">
                            <input type="hidden" value="" hidden name="ids" class="form-control"
                                id="IDsSelected2">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('front.express.export') }}">
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
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{ __('Action Status') }}</label>
                            <select name="acstatus" class="form-control" id="">
                                <option value="">{{ __('All') }}</option>
                                <option value="0">{{ __('New') }}</option>
                                <option value="1">{{ __('Processing') }}</option>
                                <option value="2">{{ __('Delivered') }}</option>
                                <option value="3">{{ __('Returned') }}</option>
                                <option value="4">{{ __('Pending Payments') }}</option>
                                <option value="5">{{ __('Payment Successful') }}</option>
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
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">{{ __('Action Status') }}</label>
                            <select name="status" class="form-control" id="recipient-name">
                                <option value="0">New</option>
                                <option value="1">Processing</option>
                                <option value="2">Delivered</option>
                                <option value="3">Returned</option>
                                <option value="4">Pending Payments</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-process" class="col-form-label">{{ __('Proccess') }}</label>
                            <select name="process" class="form-control" id="recipient-process">
                                <option value="<=">Greater Than or equal</option>
                                <option value=">=">Less Than or equal</option>
                                <option value="=">Equal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">{{ __('Cash On Delivery') }}</label>
                            <input type="number" name="cod" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control">
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
                    type="button">{{ __('All') }}
                    ({{ $ships->count() }})</button>
            </li>

            @php 
                $status_numbers = config('constants.STATUS_NUMBER');
            @endphp 
            
            @foreach($status_numbers as $status_number)
            <li class="nav-item">
                <button class="nav-link text-dark"
                        id="{{ getStatusInfo($status_number,'id') }}_tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#{{ getStatusInfo($status_number,'id') }}"
                        type="button">
                        {{ getStatusInfo($status_number) }}
                    ({{ $ships->where('status', $status_number)->count() }})
                </button>
            </li>
            @endforeach
        
        </ul>
        <style>
            .datatable-container {
    overflow-x: auto;
    white-space: nowrap; /* Prevents text wrapping */
}
        </style>
        <div class="card-body tab-content" id="myTabContent">
            <div class="tab-pane fade show rounded-3 active datatable-container" id="all" role="tabpanel" aria-labelledby="all-tab">
                {{ $dataTable->table() }}
            </div>
            @foreach($status_numbers as $status_number)
            <div class="tab-pane fade show rounded-3" id="{{ getStatusInfo($status_number,'id') }}">
                {{-- {{ $dataTable->table() }} --}}
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th width="50px"><input type="checkbox" id="master"></th>
                            <th>{{ __('Created.') }}</th> 
                            <th>{{ __('City') }}</th>
                            <th>{{ __('Phone') }}</th> 
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', $status_number) as $ship)
                            <tr>
                                <td><input type="checkbox" class="sub_chk" data-id="{{ $ship->id }}"></td>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th> 
                                <td>{{ App\Models\City::findOrFail($ship->consignee_city)->name }}</td>
                                <td>{{ $ship->consignee_phone }}</td> 
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    @php
                                    $shipmentImp = App\Models\ShipmentImport::where('awb', $ship->shipmentID)->first();
                                    if ($shipmentImp) {
                                        $transaction = App\Models\Transaction::find($shipmentImp->transaction_id);
                                    }
                                    
                                @endphp
                                @if($shipmentImp) @if($transaction) @if ($transaction->image != 'N/A')  <a href="{{ url($transaction->image) }}" style="background-color: yellow; border-color: yellow;" target="_blanck" class="btn btn-info"><span class="text text-warning">$</span></a> @endif @endif @endif
                                    {{-- <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a> --}}
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}"
                                        tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">
                                                        {{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id"
                                                                value="{{ $ship->id }}" class="form-control"
                                                                id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
          
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts() }}      
   @endpush
   
@endsection
