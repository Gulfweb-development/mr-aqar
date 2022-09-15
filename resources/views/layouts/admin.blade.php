<!DOCTYPE html>
<html lang="en" @if(app()->getLocale()== 'ar') dir="rtl" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{__('PageTitle')}}">
    <meta name="keywords" content="{{__('PageTitle')}}">
    <meta name="author" content="GulfWeb">
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    <title>{{ config('app.name') }}</title>

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

    <!-- prism css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/prism.css')}}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">

    <!-- DatePicker css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/date-picker.css')}}">

{{--    <!-- Datatable css -->--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">--}}

    <!-- SVG icon css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/whether-icon.css')}}">

    <!-- Owl css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/owlcarousel.css')}}">

    <!-- vertical-menu css -->
    <link  rel="stylesheet" type="text/css"  href="{{asset('css/vertical-menu.css')}}">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom-styles.css')}}">

    <!-- Responsive css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">

    <!-- latest jquery-->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}" ></script>
    <link href="/css/select2.css" rel="stylesheet" />
    <script src="/js/select2.js"></script>
    <style>

    </style>






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
    <link rel="stylesheet" href="{{ asset('css/main/custom.css') }}">





    @yield('css')

</head>
<body @if(\Illuminate\Support\Facades\App::getLocale() == 'ar') class="rtl" @endif>

<div id="loaderBox">
    <!-- Loader starts -->
@include('components.loader')
     <!-- Loader ends -->
</div>


<div class="page-wrapper">{{--box-layout--}}

    <!--Page Header Start-->

        @include('layouts.pageHeader')

    <!--Page Header Ends-->

    <!--vertical menu start-->

        @include('layouts.menu')

    <!--vertical menu ends-->

    <div @if(app()->getLocale() == 'ar') class="page-body-wrapper rtl" @else class="page-body-wrapper" @endif>

        <div class="page-body vertical-menu-mt" @if(!isset($crumbs)) style="padding: 0; margin: 0;" @endif>
            <!-- Container-fluid starts -->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                @if(isset($title))
                                    <h3>
                                        {{$title}}
                                        @if(isset($subtitle))
                                            <small>{{$subtitle}}</small>
                                        @endif
                                    </h3>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                @if(isset($crumbs) && request()->route()->getName()!="dashboard")
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
                                    @foreach($crumbs as $key => $crumb)
                                        <li class="breadcrumb-item">
                                            <a href="{{$crumb}}">
                                                {{$key}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Container-fluid Ends -->

            <!-- Container-fluid starts -->
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
            <!-- Container-fluid Ends -->

        </div>
    </div>
</div>

<!-- Bootstrap js-->
<script src="{{asset('js/bootstrap/popper.min.js')}}" ></script>
<script src="{{asset('js/bootstrap/bootstrap.js')}}" ></script>

<!-- Counter js-->
<script src="{{asset('js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('js/counter/counter-custom.js')}}"></script>

<!-- prism js -->
<script src="{{asset('js/prism/prism.min.js')}}"></script>

<!-- clipboard js -->
<script src="{{asset('js/clipboard/clipboard.min.js')}}" ></script>

<!-- custom card js  -->
<script src="{{asset('js/custom-card/custom-card.js')}}" ></script>

<!-- owlcarousel js-->
<script src="{{asset('js/owlcarousel/owl.carousel.js')}}" ></script>

<!--Datepicker js-->
<script src="{{asset('js/date-picker/datepicker.js')}}"></script>
<script src="{{asset('js/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('js/date-picker/datepicker.custom.js')}}"></script>

<!--General-widget page-->
<script src="{{asset('js/general-widget.js')}}" ></script>

<!--Height Equal Js-->
<script src="{{asset('js/height-equal.js')}}"></script>

<!-- Theme js-->
<script src="{{asset('js/script.js')}}" ></script>

<!-- SmartMenus jQuery plugin -->
<script  src="{{asset('js/vertical-menu.js')}}"></script>

<!--drilldown menu-->
<script src="{{asset('js/jquery.drilldown.js')}}"></script>

<!--Mega menu menu-->
<script src="{{asset('js/megamenu.js')}}"></script>

<!--Sweet Alert-->
<script src="{{asset('js/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{asset('js/sweet-alert/app.js')}}"></script>

<script>
    function destroyByForm(id) {
        swal({
            title: "{{__('Are you sure you want to delete this item?')}}",
            text: "{{__('Be aware that deletion process is non-returnable')}}",
            icon: "warning",
            buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('destroy-form-'+id).submit();
            }
        });
    }
</script>
@yield('scripts')
<script>
    $(function () {
        $("#main-menu > li").on('mouseleave',function () {
            $(this).children('ul').hide();
            $(this).children('a').removeClass("highlighted");
        });
        @if(session('success'))
            swal({"title":"Successfully performed", "icon": "success"});
        @endif
    });
</script>

</body>
</html>
