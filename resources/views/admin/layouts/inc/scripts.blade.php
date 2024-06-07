    <!-- latest jquery-->
    <script src="{{ asset('assets/admin')}}/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/admin')}}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/admin')}}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{ asset('assets/admin')}}/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/admin')}}/js/scrollbar/simplebar.js"></script>
    <script src="{{ asset('assets/admin')}}/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/admin')}}/js/select2/select2.full.min.js"></script>
    <script src="{{ asset('assets/admin')}}/js/select2/select2-custom.js"></script>

    <script src="{{ asset('assets/admin')}}/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/admin')}}/js/sidebar-menu.js"></script>

    <script src="{{ asset('assets/admin') }}/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/admin') }}/js/datatable/datatables/datatable.custom.js"></script>
    <script src="{{ asset('assets/admin') }}/js/tooltip-init.js"></script>
    <script src="{{ asset('assets/admin') }}/js/general-widget.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/chartist/chartist.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/knob/knob.min.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/knob/knob-chart.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/apex-chart/apex-chart.js"></script>
    <script src="{{ asset('assets/admin')}}/js/chart/apex-chart/stock-prices.js"></script>
    <script src="{{ asset('assets/admin')}}/js/notify/bootstrap-notify.min.js"></script>
    <script src="{{ asset('assets/admin')}}/js/dashboard/default.js"></script>
    <!-- <script src="{{ asset('assets/admin')}}/js/notify/index.js"></script> -->
    <script src="{{ asset('assets/admin')}}/js/datepicker/date-picker/datepicker.js"></script>
    <script src="{{ asset('assets/admin')}}/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="{{ asset('assets/admin')}}/js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="{{ asset('assets/admin')}}/js/typeahead/handlebars.js"></script>
    <script src="{{ asset('assets/admin')}}/js/typeahead/typeahead.bundle.js"></script>
    <script src="{{ asset('assets/admin')}}/js/typeahead/typeahead.custom.js"></script>
    <script src="{{ asset('assets/admin')}}/js/typeahead-search/handlebars.js"></script>
    <script src="{{ asset('assets/admin')}}/js/typeahead-search/typeahead-custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/admin')}}/js/script.js"></script>
    @stack('scripts')
    <script>
        $(".basic-1").DataTable({
            "order": [[0, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#shipment-table_processing').html('');
            $('#shipment-table_processing').html('جاري تحميل البيانات');
        })
    </script>



    {{-- @if(session()->has('success'))
    <script>
        $.notify('{{ session()->get("success") }}',{
            type: 'success',
            allow_dismiss: false,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            animate:{
                enter:'animated fadeInDown',
                exit:'animated fadeOutUp'
            }
        });
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        $.notify('{{ session()->get("error") }}',{
            type: 'danger',
            allow_dismiss: false,
            delay: 10000,
            showProgressbar: true,
            timer: 10000,
            animate:{
                enter:'animated fadeInDown',
                exit:'animated fadeOutUp'
            }
        });
    </script>
    @endif --}}

    
    <!-- login js-->
    <!-- Plugin used-->
