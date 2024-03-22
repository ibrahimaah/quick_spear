@extends('layouts.dashboard')
@section('content')
    @php
        // dd($shipment);
    @endphp
    <section class="container card mb-5 p-0">
        <div class="col-12 card-header">
            <h4>
                {{ __('Shipping') }} {{ $date_from->format('Y-m-d') . ' - ' . $to->addDays(30)->format('Y-m-d') }}
            </h4>

            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                data-bs-target="#Filter">{{ __('Filter') }}</button>

            <div class="modal fade" id="Filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="get">
                            <div class="modal-body">
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text1" class="col-form-label">{{ __('From') }}</label>
                                        <input type="date" name="from" class="form-control" id="message-text1">
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                        <input type="date" name="to" class="form-control" id="message-text">
                                    </div>
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
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Drafts') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                {{ $shipment->where('status', 0)->count() }}
                            </h4>
                            <h4 style="font-weight: 700;">
                                @if ($shipment->count() !== 0)
                                    {{ number_format(($shipment->where('status', 0)->count() * 100) / $shipment->count(), 2) }}
                                    %
                                @else
                                    0 %
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Processing') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                {{ $shipment->where('status', 1)->count() }}
                            </h4>
                            <h4 style="font-weight: 700;">
                                @if ($shipment->count() !== 0)
                                    {{ number_format(($shipment->where('status', 1)->count() * 100) / $shipment->count(), 2) }}
                                    %
                                @else
                                    0 %
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Delivered') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                {{ $shipment->whereIn('status', [2, 4])->count() }}
                            </h4>
                            <h4 style="font-weight: 700;">
                                @if ($shipment->count() !== 0)
                                    {{ number_format(($shipment->whereIn('status', [2, 4])->count() * 100) / $shipment->count(), 2) }}
                                    %
                                @else
                                    0 %
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Returned') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                {{ $shipment->where('status', 3)->count() }}
                            </h4>
                            <h4 style="font-weight: 700;">
                                @if ($shipment->count() !== 0)
                                    {{ number_format(($shipment->where('status', 3)->count() * 100) / $shipment->count(), 2) }}
                                    %
                                @else
                                    0 %
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mb-5">
                <div id="chart"></div>
            </div>
        </div>
    </section>
    <section class="container card mb-5 p-0">
        <div class="card-header">
            <h3 class="card-title">{{ __('Payments') }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Cash In') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                0
                            </h4>
                            <h4 style="font-weight: 700;">
                                0%
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">{{ __('Cash Out') }}</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                0
                            </h4>
                            <h4 style="font-weight: 700;">
                                0%
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card px-3 py-2">
                        <div class="d-flex justify-content-between flex-row-reverse">
                            <h6 class="text-muted">مسودات</h6>
                            <h6 class="text-muted">{{ __('Percentage') }}</h6>
                        </div>
                        <div class="d-flex  justify-content-between flex-row-reverse">
                            <h4 class="scolor" style="font-weight: 700;">
                                0
                            </h4>
                            <h4 style="font-weight: 700;">
                                0%
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div id="chart2"></div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        var options = {
            chart: {
                type: 'line'
            },
            stroke: {
                curve: 'smooth',
            },
            series: [{
                    name: '{{ __('Drafts') }}',
                    data: [
                        @foreach (array_reverse($shipment_count['counts_list']) as $count)
                            "{{ $count }}",
                        @endforeach
                    ]
                },
                {
                    name: "{{ __('Delivered') }}",
                    data: [
                        @foreach (array_reverse($shipment_count['counts_list2']) as $count)
                            "{{ $count }}",
                        @endforeach
                    ]
                },
                {
                    name: "{{ __('Processing') }}",
                    data: [
                        @foreach (array_reverse($shipment_count['counts_list1']) as $count)
                            "{{ $count }}",
                        @endforeach
                    ]
                },
                {
                    name: "{{ __('Returned') }}",
                    data: [
                        @foreach (array_reverse($shipment_count['counts_list3']) as $count)
                            "{{ $count }}",
                        @endforeach
                    ]
                }
            ],
            xaxis: {
                categories: [
                    @foreach ($shipment_count['days_list'] as $day)
                        "{{ $day }}",
                    @endforeach
                ]
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        var chart2 = new ApexCharts(document.querySelector("#chart2"), options);

        chart.render();
        chart2.render();
    </script>
@endsection
