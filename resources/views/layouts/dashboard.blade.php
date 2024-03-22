<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Ship</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicons -->
    {{--  <link href="{{ asset('assets') }}/img/favicon.png" rel="icon" />
    <link href="{{ asset('assets') }}/img/apple-touch-icon.png" rel="apple-touch-icon" />  --}}

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->

    <!-- Vendor CSS Files -->
    {{--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous" />  --}}
        <link href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap{{ app()->getLocale() === 'ar' ? '.rtl' : '' }}.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="{{ asset('assets') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    {{--  <link id="color" rel="stylesheet" href="{{asset('assets/admin')}}/css/color-5.css">  --}}
    <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400&display=swap" rel="stylesheet" />
    @yield('style')
    <style>
                .dashboardbox {
                    background-color: #fff;
                    padding: 10px;
                    border-radius: 5px;
                    border: 1px solid #b8b8b8;
                }
            </style>
</head>

<body class="bg-light">
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center p-3 bg-light shadow-sm p-3 mb-5 bg-body rounded">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="logo mx-4">
                {{-- <h1><a href="/">Logo</a></h1> --}}
                 <a href="/"><img src="{{ asset(App\Models\Setting::first()->website_logo ?? 'assets/images/logo/logo.png') }}" alt="" class="img-fluid"></a>
            </div>

            <nav id="navbar" class="navbar justify-content-between">
                <i class="bi bi-list mobile-nav-toggle"></i>
                <ul class="justify-content-between">
                    @if (auth()->check())
                    <li><a class="nav-link mx-1 scrollto {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('front.user.dashboard') }}">{{ __('Home') }}</a></li>
                    <li><a class="nav-link mx-1 scrollto {{ request()->is('express') || request()->is('express/*') ? 'active' : '' }}" href="{{ route('front.express.index') }}">{{ __('Shipping') }}</a></li>
                    <li><a class="nav-link mx-1 scrollto" href="{{ route('front.payments.index') }}">{{ __('Payments') }}</a></li>
                    <li><a class="nav-link mx-1 scrollto {{ request()->is('profile/*') ? 'active' : '' }}" href="{{ route('front.user.account') }}">{{ __('Account') }}</a></li>
                    @elseif(auth('team')->check() && auth('team')->user()->role == 'all')
                    <li><a class="nav-link mx-1 scrollto {{ request()->is('express') || request()->is('express/*') ? 'active' : '' }}" href="{{ route('front.express.index') }}">{{ __('Shipping') }}</a></li>
                    <li><a class="nav-link mx-1 scrollto" href="{{ route('front.payments.index') }}">{{ __('Payments') }}</a></li>
                    @endif
                    @if (auth('team')->check() && auth('team')->user()->role == 'shipping')
                        <li><a class="nav-link mx-1 scrollto {{ request()->is('express') || request()->is('express/*') ? 'active' : '' }}" href="{{ route('front.express.index') }}">{{ __('Shipping') }}</a></li>
                    @endif
                    @if (auth('team')->check() && auth('team')->user()->role == 'payments')
                        <li><a class="nav-link mx-1 scrollto" href="{{ route('front.payments.index') }}">{{ __('Payments') }}</a></li>
                    @endif
                    @php
                    use \Mcamara\LaravelLocalization\LaravelLocalization;
                    $loc = new LaravelLocalization();
                    @endphp
                    <li><a class="nav-link mx-1 scrollto" href="{{ app()->getLocale() == 'ar' ? $loc->getLocalizedURL('en') : $loc->getLocalizedURL('ar') }}">{{ app()->getLocale() == 'en' ? 'عربي' : 'English' }}</a></li>
                </ul>
            </nav>
            <!-- .navbar -->
            <nav id="navbar" class="navbar order-last order-lg-0">
                @if (auth()->check() || auth('team')->check())
                <div class="nav-item dropdown container d-flex align-items-center justify-content-end">
                    <a href="#">
                        <span class="mx-2">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul>
                        <li><a href="{{ route('front.user.account') }}">{{ __('Profile') }}</a></li>
                        <li><a href="{{ route('front.user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('front.logout') }}">{{ __('Logout') }}</a></li>
                    </ul>
                </div>
                @else
                <a href="{{ route('front.get_register') }}" class="btn btn-outline-primary px-3 py-2 mx-3">{{ __('Register') }}</a>
                <a href="{{ route('front.get_login') }}" class="btn btn-outline-primary px-3 py-2">{{ __('Log In') }}</a>
                @endif
            </nav>
        </div>
    </header>
    <!-- End Header -->
    <main id="main">
        @yield('content')
    </main>
    <!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets') }}/vendor/purecounter/purecounter.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="{{ asset('assets') }}/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets') }}/js/main.js"></script>
    @yield('js')
    <script src="{{ asset('assets') }}/js/repeater.js" type="text/javascript"></script>
    <script>
        /* Create Repeater */
        $("#repeater").createRepeater({
            showFirstItemToDefault: true,
            fresh:false
        });
    </script>

</body>

</html>

