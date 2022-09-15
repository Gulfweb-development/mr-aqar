<!doctype html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="{{ asset('css/main/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/responsive.css') }}">

    <title>googleme - Buy & Sell Properties</title>

    <link rel="icon" type="image/png" href="{{ asset('images/main/favicon.png') }}">
</head>
<body>






<!-- Start Login Area -->
<section class="login-area">
    <div class="row m-0">
        <div class="col-lg-6 col-md-12 p-0">
            <div class="login-image">
                <img src="{{ asset('images/main/login-bg.jpg') }}" alt="image">
            </div>
        </div>

        <div class="col-lg-6 col-md-12 p-0">
            <div class="login-content">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="login-form">
                            <div class="logo">
                                <a href="{{ '/' }}"><img src="{{ asset('images/main/logo.png') }}" alt="image"></a>
                            </div>

                            <h3>Reset Password</h3>

                            <form method="POST" action="{{route('password.token',['locale'=>app()->getLocale(),'token'=>request()->token])}}">
                                @csrf
                                <input type="hidden" name="token" value="{{ request()->token }}">

                                <div class="form-group">
                                    <label for="email" class="col-md-4 col-form-label ">{{ __('E-Mail Address') }}</label>
                                    <input type="email" id="email" placeholder="Your Register Email Address" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-md-4 col-form-label ">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" required autocomplete="new-password" value="{{ old('password') }}">
                                    @if($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('password')}}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 col-form-label ">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control @if($errors->has('password-confirm')) is-invalid @endif" name="password-confirm" required autocomplete="new-password" value="{{ old('password-confirm') }}">
                                    @if($errors->has('password-confirm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('password-confirm')}}</strong>
                                    </span>
                                    @endif
                                </div>

                                <button type="submit">Reset Password</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Login Area -->






<!-- Links of JS files -->
<script src="{{ asset('js/main/jquery.min.js') }}"></script>
<script src="{{ asset('js/main/popper.min.js') }}"></script>
<script src="{{ asset('js/main/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/main/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/main/appear.min.js') }}"></script>
<script src="{{ asset('js/main/odometer.min.js') }}"></script>
<script src="{{ asset('js/main/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/main/parallax.min.js') }}"></script>
<script src="{{ asset('js/main/slick.min.js') }}"></script>
<script src="{{ asset('js/main/rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/main/nice-select.min.js') }}"></script>
<script src="{{ asset('js/main/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('js/main/meanmenu.min.js') }}"></script>
<script src="{{ asset('js/main/wow.min.js') }}"></script>
<script src="{{ asset('js/main/form-validator.min.js') }}"></script>
<script src="{{ asset('js/main/contact-form-script.js') }}"></script>
<script src="{{ asset('js/main/ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/main/main.js') }}"></script>

</body>
</html>
