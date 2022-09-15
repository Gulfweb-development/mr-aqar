    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined">
    <link rel="stylesheet" href="{{ asset('asset/css/libs/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/libs/material-components-web.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/skins/blue.css') }}">
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('asset/css/rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('asset/css/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/css/app.css') }}">

    <style>
        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }
        footer::before {
            background-image: url("/images/main/footer.jpg") !important;
        }
    </style>
