<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="">
                <img class="img-fluid for-light" width="50" src="{{ asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo.png') }}" alt="">
                <img class="img-fluid for-dark" width="50" src="{{ asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo_dark.png') }}"
                    alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}">
            <img class="img-fluid" width="50"
                    src="{{ asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo.png') }}"
                    alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                                src="{{ asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo.png') }}"
                                alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}"><i
                                data-feather="airplay"></i><span class="">لوحة التحكم</span></a>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="users"></i><span class="">المشرفين</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.admins.index') }}">عرض المشرفين</a></li>
                            <li><a href="{{ route('admin.admins.create') }}">اضافة مشرف</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\Admin::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="users"></i><span class="">المستخدمين</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.users.index') }}">عرض المستخدمين</a></li>
                            <li><a href="{{ route('admin.users.create') }}">اضافة مستخدم</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\User::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                        <i data-feather="users"></i><span class="">المندوبين</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.delegates.index') }}">عرض المندوبين</a></li>
                            <li><a href="{{ route('admin.delegates.create') }}">اضافة مندوب</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\Admin::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">المدن</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.cities.index') }}">عرض المدن</a></li>
                            <li><a href="{{ route('admin.cities.create') }}"> اضافة مدينة</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\City::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">العناوين</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.address.index') }}">عرض العناوين</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\City::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">طلبات التعديل</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.orders.index') }}">عرض كل الطلبات</a></li>
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\EditOrder::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">الشحنات</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.shipments.create') }}">إضافة شحنة</a></li>
                            
                            <li><a href="{{ route('admin.shipments.index') }}">عرض كل الشحنات</a></li>
                           {{-- @php 
                                $statuses = config('constants.STATUS_NUMBER');
                            @endphp 
                            @foreach($statuses as $status)
                            <li><a href="{{ route('admin.get_shipments_by_status',['status'=>$status]) }}">{{ getStatusInfo($status) }}</a></li>
                            @endforeach
                            --}}
                        </ul>
                        <span class="badge rounded-pill badge-success">{{ App\Models\Shipment::count() }}</span>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                        data-feather="flag"></i><span class="">المدفوعات</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.transactions.index') }}">عرض كل المدفوعات </a></li>
                            <li><a href="{{ route('admin.requests.index') }}">عرض كل طلبات الدفع </a> </li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">رسائل الدعم</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.contacts.index') }}">رسائل الدعم</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="flag"></i><span class="">الإعدادات</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.setting.index') }}">الإعدادات</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
