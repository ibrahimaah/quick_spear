<!DOCTYPE html>
<html dir="rtl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/admin/images/logo/logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/admin/images/logo/logo.png')}}" type="image/x-icon">
    <title>Dashboard</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/style.css">
    <link id="color" rel="stylesheet" href="{{asset('assets/admin')}}/css/color-5.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin')}}/css/responsive.css">
  </head>
  <body class="rtl">
    <!-- login page start-->
    <div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-12 p-0">
          <div class="login-card">
            <div>
              <div><a class="logo" href="#"><img class="img-fluid for-light" width="150" src="{{asset('assets/admin/images/logo/logo.png')}}" alt="looginpage"></a></div>
              <div class="login-main">
                @include('admin.layouts.inc.errors')
                @include('admin.layouts.inc.success')
                <form class="theme-form" method="POST" action="{{ route('admin.login') }}">
                    @csrf
                  <h4>تسجيل الدخول الي حسابك</h4>
                  <p>ادخل رقم الهاتف وكلمة المرور لتسجل دخولك</p>
                  <div class="form-group">
                    <label class="col-form-label">رقم الهاتف</label>
                    <input class="form-control" type="text" name="phone" value="0798711008" required placeholder="055555555">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">كلمة المرور</label>
                    <div class="form-input position-relative">
                        {{-- <div class="show-hide"><span class="show"></span></div> --}}
                      <input class="form-control" type="password" value="12345678" name="password" required placeholder="*********">
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <div class="checkbox p-0">
                      <input id="checkbox1" name="remember" type="checkbox">
                      <label class="text-muted" for="checkbox1">تذكرني</label>
                    </div>
                    <div class="text-end mt-3">
                        {{-- @if (Route::has('password.request'))
                              <a class="link" href="{{ route('password.request') }}">هل نسيت كلمةالمرور ؟</a>
                            @endif --}}
                      <button class="btn btn-primary btn-block w-100" type="submit">دخول</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="{{asset('assets/admin')}}/js/jquery-3.5.1.min.js"></script>
      <!-- Bootstrap js-->
      <script src="{{asset('assets/admin')}}/js/bootstrap/bootstrap.bundle.min.js"></script>
      <!-- feather icon js-->
      <script src="{{asset('assets/admin')}}/js/icons/feather-icon/feather.min.js"></script>
      <script src="{{asset('assets/admin')}}/js/icons/feather-icon/feather-icon.js"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="{{asset('assets/admin')}}/js/config.js"></script>
      <!-- Plugins JS start-->
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="{{asset('assets/admin')}}/js/script.js"></script>
      <!-- login js-->
      <!-- Plugin used-->
    </div>
  </body>
</html>
