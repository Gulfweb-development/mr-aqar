<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cargo Logistics">
    <meta name="keywords" content="Cargo Logistics">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon" />
    <title>{{ config('app.name') }}</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome.css')}}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/themify.css')}}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

    <!-- Responsive css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">

</head>
<body>

<!-- Loader starts -->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <h4>{{__('Have a great day at work today')}} <span>&#x263A;</span></h4>
    </div>
</div>
<!-- Loader ends -->

<!--page-wrapper Start-->
<div class="page-wrapper">
    <div class="container-fluid"> @yield('content') </div>
</div>
<!--page-wrapper Ends-->

<!-- latest jquery-->
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap/bootstrap.js')}}"></script>

<!-- Theme js-->
<script src="{{asset('js/script.js')}}"></script>

</body>
</html>
