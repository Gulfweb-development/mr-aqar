<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="universal admin is super flexible, powerful, clean & modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, universal admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon" />
    <title>{{$title}}</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome.css')}}">

    <!-- ico-font -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/icofont.css')}}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/themify.css')}}">

    <!-- Flag icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/flag-icon.css')}}">

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
        <h4>Have a great day at work today <span>&#x263A;</span></h4>
    </div>
</div>
<!-- Loader ends -->

<!--page-wrapper Start-->
<div class="page-wrapper">
    <!--error-400 start-->
    <div class="error-wrapper">
        <div class="container">
            <img src="{{asset('images/sad.png')}}" class="img-100" alt="">
            <div class="error-heading">
                <img src="{{asset('images/cloud-bg-1.png')}}" class="cloud-first" alt="">
                <h2 class="headline font-{{$theme}}">{{$code}}</h2>
                <img src="{{asset('images/cloud-bg-2.png')}}" class="cloud-second" alt="">
            </div>
            <div class="col-md-8 offset-md-2">
                <p class="sub-content">The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.
                </p>
            </div>
            <div class="">
                <button class="btn btn-{{$theme}}-gradien btn-lg" onclick="window.history.back();">GO BACK</button>
            </div>
        </div>
    </div>
    <!--error-400 end-->
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
