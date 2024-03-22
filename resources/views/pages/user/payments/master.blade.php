@extends('layouts.dashboard')
{{--  @section('style')
<style>
    .datatable_filter label {
        float: left !important;
    }
</style>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
@endsection  --}}
@section('content')
<section class="container-fluid mt-0 pt-0">
    <div class="row bg-light">
        <div class="d-flex flex-column flex-shrink-0" style="width: 220px;height:100vh">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">{{ __('Payments') }}</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('front.payments.index') }}" class="nav-link link-dark @yield('active1')">
                        {{ __('Cash On Delivery') }}
                    </a>
                </li>
                {{--  <li>
                    <a href="#" class="nav-link link-dark @yield('active2')">
                        الفريق
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark @yield('active3')">
                        الوثائق
                    </a>
                </li>  --}}
                {{-- <li>
                    <a href="{{ route('front.user.payment_methods') }}" class="nav-link link-dark @yield('active4')">
                        {{ __('Payment Method') }}
                    </a>
                </li>
                 <li>
                    <a href="{{ route('front.user.aramex_account') }}" class="nav-link link-dark @yield('active5')">
                        {{ __('Company Delivery') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('front.user.address') }}" class="nav-link link-dark @yield('active6')">
                        {{ __('Address') }}
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark @yield('active7')">
                        {{ __('Local Price') }}
                    </a>
                </li> --}}
            </ul>
        </div>

        <div class="col px-5">
            @yield('paymentsContent')
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@if (app()->getLocale() === 'ar')
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "order": [[1, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });

        $('.basic-1').DataTable({
            "order": [[1, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });

        $('#basic-1').DataTable({
            "order": [[1, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });
        $('.js-example-basic-single').select2();
    } );
</script>
@else
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "order": [[1, 'desc']]
        });
        $('.basic-1').DataTable({
            "order": [[1, 'desc']]
        });
        $('#basic-1').DataTable({
            "order": [[1, 'desc']]
        });
        $('.js-example-basic-single').select2();
    } );
</script>
@endif
@endsection
