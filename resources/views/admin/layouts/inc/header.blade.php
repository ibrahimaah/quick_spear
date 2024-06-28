<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href=""><img class="img-fluid" src="{{asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo.png')}}"
                        alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="left-header col horizontal-wrapper ps-0"></div>
        <div class="nav-right col-12 pull-right right-header p-0">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    {{-- <div class="notification-box"><i data-feather="bell"> </i><livewire:notifications-count /></div> --}}
                    {{-- <ul class="notification-dropdown onhover-show-div"> --}}
                        {{-- <li>
                            <i data-feather="bell"></i>
                            <h6 class="f-18 mb-0">التنبيهات</h6>
                        </li> --}}
                        {{-- <livewire:notifications /> --}}
                    {{-- </ul> --}}
                </li>
                <li>
                    <form id="mode-form" action="{{route('admin.mode')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <div class="mode"><a
                            onclick="event.preventDefault(); document.getElementById('mode-form').submit();"><i
                                class="fa {{ auth('admin')->user()->dark == 0 ? 'fa-moon-o' : 'fa-lightbulb-o' }}"></i></a>
                    </div>
                </li>
                <li class="profile-nav onhover-dropdown p-0 me-0">
                    <div class="media profile-media">
                        <div class="media-body"><span>{{ auth('admin')->user()->name }}</span>
                            <p class="mb-0 font-roboto">{{ auth('admin')->user()->phone }}<i
                                    class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a class="dropdown-item" href="{{route('admin.logout')}}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="power"></i>
                                تسجيل الخروج </a>
                            <form id="logout-form" action="{{route('admin.logout')}}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
        <div class="ProfileCard-avatar"><svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
        <div class="ProfileCard-details">
        <div class="ProfileCard-realName"></div>
        </div>
        </div>
      </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
        </script>
    </div>
</div>
