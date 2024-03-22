@extends('layouts.dashboard')
@section('style')
    <style>
        .datatable_filter label {
            float: left !important;
        }
    </style>
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <section class="container-fluid mt-0 pt-0">
        <div class="row bg-light">
            <div class="d-flex flex-column flex-shrink-0" style="width: 220px;height:100vh">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">{{ __('Shipping') }}</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="{{ route('front.express.index') }}" class="nav-link link-dark @yield('active1')">
                            {{ __('Local Shipping') }}
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{ route('front.contact') }}" class="nav-link link-dark">
                            {{ __('International Shipping') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.express.trackingPickup') }}" class="nav-link @yield('active2') link-dark">
                            {{ __('Pickup') }}
                        </a>
                    </li> --}}
                </ul>
            </div>

            <div class="col px-5">
                @yield('expressContent')
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
                    "order": [
                        [0, 'desc']
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
                    }
                });

                $('.basic-1').DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
                    }
                });

                $('#basic-1').DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
                    }
                });
                $('.js-example-basic-single').select2();
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('.datatable').DataTable({
                    "order": [
                        [0, 'desc']
                    ]
                });
                $('.basic-1').DataTable({
                    "order": [
                        [0, 'desc']
                    ]
                });
                $('#basic-1').DataTable({
                    "order": [
                        [0, 'desc']
                    ]
                });
                $('.js-example-basic-single').select2();
            });
        </script>

@endif
<script type="text/javascript">
    $(document).ready(function () {

        $('#master').on('click', function(e) {
        if($(this).is(':checked',true))
        {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked',false);
        }
        });

        $('.print_all').on('click', function(e) {
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });


            if(allVals.length <=0)
            {
                alert("حدد عنصر واحد ع الاقل ");
            }  else {
                var check = confirm("هل انت متاكد؟");
                if(check == true){
                    var join_selected_values = allVals.join(",");

                    // console.log(join_selected_values);
                    document.getElementById("IDsSelected").value = join_selected_values;
                    document.getElementById("IDsSelected2").value = join_selected_values;

                    $.each(allVals, function( index, value ) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();

            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        // alert(data['success']);
                        console.log(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
            return false;
        });
    });
</script>
@stack('scripts')
@endsection
