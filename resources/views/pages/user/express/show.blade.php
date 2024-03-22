{{-- @dd($data) --}}
@extends('pages.user.express.index')

@section('expressContent')
<div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <h3 class="NavigateHeader">معلومات الشحنة</h3>
    </div>
    <div class="mb-3 col-sm-12 col-lg-10 mx-auto text-right ">
        @if ($shipment->shipmentLabelURL)
            <a href="{{ asset($shipment->shipmentLabelURL) }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-print"></i>
                {{ __('Print') }}
            </a>
        @else
        <a href="#" class="btn disable btn-primary">
            <i class="bi bi-print"></i>
            {{ __('Print') }}
        </a>
        @endif
    </div>
    <div class="d-lg-flex flex-row flex-xs-column align-self-center justify-content-between col-lg-10 mx-auto mb-1">
        <div class="col-sm-12 col-lg-3 mb-2 p-0 ">
            <div class="dashboardbox text-center  " style="height: 190px; overflow: hidden;">
                <img src="data:image/png;base64,{{ $barcode }}" width="180" height="90" alt="" class="my-4">
                <h4 class="scolor text-center" style="font-weight: 700;">
                    {{ $shipment->shipmentID }}
                </h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3 mb-2 p-0">
            <div class="dashboardbox">
                <h6 class="text-muted">{{ __('Provider') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>Aramex</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">{{ __('Action Status') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->get_status() }}</span></h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3 mb-2 p-0">
            <div class="dashboardbox ">
                <h6 class="text-muted">{{ __('Action Initiated By') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->user->name ?? '' }}</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">{{ __('City') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->address->City->name ?? '' }}</span>
                </h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-2 mb-2 p-0">
            <div class="dashboardbox ">
                <h6 class="text-muted">{{ __('Type') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>DOMESTIC</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">{{ __('Cash On Delivery') }}</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->cash_on_delivery_amount }} JOD</span>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <div class="card mb-3">
            <div class="card-header">{{ __('Account Informations') }} {{ __('Shipper') }}</div>
            <div class="card-body mb-3">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('Name') }}</label></div>
                            <div class="desc">
                                {{ $shipment->address->name }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Phone') }}</label></div>
                            <div class="desc">
                                {{ $shipment->address->phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Country') }}</label></div>
                            <div class="desc">
                                {{ __('Jordan') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('City') }}</label></div>
                            <div class="desc">
                                {{ $shipment->address->City->name ?? '' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Region') }}</label></div>
                            <div class="desc">
                                {{ $shipment->address->region }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Description') }}</label></div>
                            <div class="desc">
                                {{ $shipment->address->desc }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card">
            <div class="card-header">{{ __('Account Informations') }} {{ __('Consignee') }}</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('Name') }}</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_name }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Phone') }}</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Phone') }} 2</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_cell_phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Zip / Postal Code') }}</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('Country') }}</label></div>
                            <div class="desc">
                                {{ __('Jordan') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('City') }}</label></div>
                            <div class="desc">
                                {{ App\Models\City::find($shipment->consignee_city)->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Region') }}</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_line2 }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Description') }}</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_line1 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card">
            <div class="card-header">{{ __('Shipping Informations') }}</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-12"></div>
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('Number OF Pieces') }}</label></div>
                            <div class="desc">
                                {{ $shipment->number_of_pieces }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Comments') }}</label></div>
                            <div class="desc">
                                {{ $shipment->comments }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Created.') }}</label></div>
                            <div class="desc">
                                {{ $shipment->created_at->format('Y-m-d') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Action Initiated By') }}</label></div>
                            <div class="desc">
                                {{ $shipment->user->name ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">{{ __('Contents') }}</label></div>
                            <div class="desc">
                                {{ $shipment->description }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Weight') }}</label></div>
                            <div class="desc">
                                {{ $shipment->weight }} KG
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الوزن القابل للشحن</label></div>
                            <div class="desc">
                                {{ $shipment->weight }} KG
                            </div>
                        </div> --}}
                        <!---->
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <div class="card mb-3">
            <div class="card-header">{{ __('Payment Information') }}</div>
            <div class="card-body mb-3">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Cash On Delivery') }} (JOD)
                                </label></div>
                            <div class="desc">
                                {{ $shipment->cash_on_delivery_amount ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Cost') }} (JOD)</label></div>
                            <div class="desc">
                                {{ $shipment->collect_amount }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Additional Cost') }} (JOD)</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Rest Cost') }}</label></div>
                            <div class="desc">
                                NaN JOD
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Payment At') }}</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">{{ __('Process Number') }}</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($data))
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card mb-3">
            <div class="card-header">آخر التغييرات</div>
            <div class="card-body mb-3">
                <div class="col-sm-12">
                    <div class="table-responsive" style="font-size: 13px;">
                        <table role="table" aria-busy="false" aria-colcount="4" class="table b-table b-table-stacked-lg" id="__BVID__301">
                            <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="bg-dark text-white">
                                        <div>التاريخ</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="2" class="bg-dark text-white">
                                        <div>وصف التتبع</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="3" class="bg-dark text-white">
                                        <div>الوصف</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="4" class="bg-dark text-white">
                                        <div>الموقع</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody role="rowgroup">
                                {{-- @dd($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult !== []) --}}
                                @if (gettype($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult) == "array")
                                @foreach ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult as $track)
                                <tr role="row" class="">
                                    <td aria-colindex="1" data-label="التاريخ" role="cell" class="">
                                        <div>{{ strftime('%Y-%m-%d %H:%M', strtotime($track->UpdateDateTime)) }}</div>
                                    </td>
                                    <td aria-colindex="2" data-label="وصف التتبع" role="cell" class="">
                                        <div>{{ $track->Comments }}</div>
                                    </td>
                                    <td aria-colindex="3" data-label="الوصف" role="cell" class="">
                                        <div>{{ $track->UpdateDescription }}</div>
                                    </td>
                                    <td aria-colindex="4" data-label="الموقع" role="cell" class="">
                                        <div>{{ $track->UpdateLocation }}</div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @php
                                    $track = $data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
                                @endphp
                                <tr role="row" class="">
                                    <td aria-colindex="1" data-label="التاريخ" role="cell" class="">
                                    <div>
                                        {{ strftime('%Y-%m-%d %H:%M', strtotime($track->UpdateDateTime)) }}
                                    </div>
                                    </td>
                                    <td aria-colindex="2" data-label="وصف التتبع" role="cell" class="">
                                        <div>{{ $track->Comments }}</div>
                                    </td>
                                    <td aria-colindex="3" data-label="الوصف" role="cell" class="">
                                        <div>{{ $track->UpdateDescription }}</div>
                                    </td>
                                    <td aria-colindex="4" data-label="الموقع" role="cell" class="">
                                        <div>{{ $track->UpdateLocation }}</div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <br />
    <hr />
    <br />
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Editing Orders') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm display datatable">
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
                            @foreach($editOrders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->created_at->format('Y - m - d') }}</td>
                                <td>{{ $order->type }}</td>
                                <td><?php echo $order->desc; ?></td>
                                <td>{{ __($order->get_status()) }}</td>
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
