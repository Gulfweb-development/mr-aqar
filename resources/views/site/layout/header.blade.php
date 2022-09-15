<!DOCTYPE html>
<html lang="en" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} @hasSection('title') - @yield('title') @endif </title>
    @yield('meta')
    <link rel="icon" type="image/png" href="{{ asset('images/main/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    @include('site.layout.css')
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    @yield('header')
</head>
<body class="mdc-theme--background">
    <div class="spinner-wrapper" id="preloader">
        <div class="spinner-container">
            <div class="spinner-outer">
                <div class="spinner">
                    <img src="{{asset('images/main/loading.gif')}}" alt="loading" style="width: 100%;">
                </div>
                <p class="spinner-text">{{ __('PageTitle') }}</p>
            </div>
        </div>
    </div>
    <aside class="mdc-drawer mdc-drawer--modal sidenav" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!} style="z-index: 9999">
        <div class="row end-xs middle-xs py-1 px-3">
            <button id="sidenav-close" class="mdc-icon-button material-icons warn-color">close</button>
        </div>
        <style>
            .mdc-drawer__content * {
                direction: rtl !important;
            }
        </style>
        <hr class="mdc-list-divider m-0">
        <div class="mdc-drawer__content">
            <div class="vertical-menu">
                <div>
                    <a href="{{route('site.advertising.create', app()->getLocale())}}" class="mdc-button mdc-button--raised mb-4" style="color: white">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{ __('add_listing_title') }}</span>
                        <i class="material-icons mdc-button__icon">add</i>
                    </a>
                </div>
                <div>
                    <a href="{{'/'.app()->getLocale(). '/' }}" class="mdc-button" style="{{Route::currentRouteName() == 'Main.index' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('home_title')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{'/'.app()->getLocale(). '/required' }}" class="mdc-button" style="{{Route::currentRouteName() == 'required_for_rent' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('required_for_rent')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{ route('companies', app()->getLocale()) }}" class="mdc-button" style="{{Route::currentRouteName() == 'companies' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('companies')}}</span>
                    </a>
                </div>
{{--                <div>--}}
{{--                    <a href="{{ '/'.app()->getLocale().'/aboutus' }}" class="mdc-button" style="{{Route::currentRouteName() == 'Main.aboutus' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">--}}
{{--                        <span class="mdc-button__ripple"></span>--}}
{{--                        <span class="mdc-button__label">{{__('about_us_title')}}</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <a href="{{ '/'.app()->getLocale().'/contact' }}" class="mdc-button" style="{{Route::currentRouteName() == 'Message.create' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">--}}
{{--                        <span class="mdc-button__ripple"></span>--}}
{{--                        <span class="mdc-button__label">{{__('contact_title')}}</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
                <div>
                    @if ( app()->getLocale() == "en")
                        <span onclick="changeLng('ar')" class="mdc-button">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">العربیه</span>
                        </span>
                    @else
                        @if(env('ENGLISH_BUTTON', false))
                            <span onclick="changeLng('en')" class="mdc-button">
                                <span class="mdc-button__ripple"></span>
                                <span class="mdc-button__label">English</span>
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <hr class="mdc-list-divider m-0">
        <div class="row center-xs middle-xs py-3">
            @include('site.sections.socials', ['icon_classes' => 'mat-icon-md primary-color', 'sidebar' => true])

        </div>
    </aside>
    <div class="mdc-drawer-scrim sidenav-scrim"></div>
    <header class="toolbar-1 {{ ($header ?? '') !== 'transparent' ?: 'has-bg-image' }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
        <div id="top-toolbar" class="mdc-top-app-bar">
            <div class="theme-container row between-xs middle-xs h-100">
                <div class="row d-lg-none start-xs middle-xs">
                    <button id="sidenav-toggle" class="mdc-button mdc-ripple-surface d-md-none d-lg-none d-xl-none">
                        <span class="mdc-button__ripple"></span>
                        <i class="material-icons">menu</i>
                    </button>

                </div>
                @include('site.sections.socials', ['classes' => 'start-xs middle-xs d-none d-lg-flex d-xl-flex'])
                <div class="row end-xs middle-xs">
                    <div class="mdc-menu-surface--anchor">
                        @if(auth()->check())
                        <button class="mdc-button mdc-ripple-surface">
                            <span class="mdc-button__ripple"></span>
                            <i class="material-icons mdc-button__icon mx-1">person</i>
                            <span class="mdc-button__label">{{__('my_account_title')}}</span>
                            <i class="material-icons mdc-button__icon m-0">arrow_drop_down</i>
                        </button>
                        <div class="mdc-menu mdc-menu-surface user-menu" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!}>
                            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical" tabindex="-1">
                                <li class="user-info row start-xs middle-xs">
                                    <img src="{{ is_file(public_path(auth()->user()->image_profile)) ? asset(auth()->user()->image_profile) : asset('asset/assets/images/others/user.jpg') }}" alt="user-image" width="50">
                                    <p class="m-0">@if(auth()->user()->name){{ auth()->user()->name }}@else<a href="{{ route('Main.profile',app()->getLocale()) }}">{{ __('update_name') }}</a>@endif<br>
{{--                                        <a href="{{url(app()->getLocale().'/paymenthistory')}}" class="text_blue" style="color:#088dd3;text-decoration:none;">--}}
                                            @if($balance == 0) 0 {{__('ads_title')}}
                                            @else
                                                    <span class="">
                                                        {{ $balance['available'] }} {{__('ads_title')}}
                                                    </span>
                                                    <span class="@if( app()->getLocale() == "ar" ) mr-3 @else ml-3  @endif">
                                                        {{ $balance['available_premium'] }} {{__('premium_short')}}
                                                    </span>
                                            @endif
{{--                                        </a>--}}
                                    </p>

                                </li>
                                <li role="separator" class="mdc-list-divider m-0"></li>
                                <li>
                                    <a href="{{ route('Main.buyPackage',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "buypackage") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted ">add_circle</i>
                                        <span class="mdc-list-item__text px-3">{{__('buy_package_title')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Main.myAds',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "myads") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted">home</i>
                                        <span class="mdc-list-item__text px-3">{{__('my_ads_title')}}</span>
                                    </a>
                                </li>
                                @if(env('PACKAGE_HISTORY', false))
                                    <li>
                                        <a href="{{ route('Main.paymentHistory',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "paymenthistory") background-color: var(--mdc-theme-primary); color: white; @endif">
                                            <i class="material-icons mat-icon-sm text-muted">compare_arrows</i>
                                            <span class="mdc-list-item__text px-3">{{__('package_history_title')}}</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('Main.profile',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "profile") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted">edit</i>
                                        <span class="mdc-list-item__text px-3">{{__('edit_profile_title')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Main.changePassword',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "changepassword") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted">lock</i>
                                        <span class="mdc-list-item__text px-3">{{__('change_password_title')}}</span>
                                    </a>
                                </li>
                                <li role="separator" class="mdc-list-divider m-0"></li>
                                <li>
                                    <a href="#" class="mdc-list-item" role="menuitem" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="material-icons mat-icon-sm text-muted">power_settings_new</i>
                                        <span class="mdc-list-item__text px-3">{{__('Logout')}}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                            <div class="row start-xs middle-xs fw-500 d-md-flex d-lg-flex d-xl-flex">
                                <span class="d-flex center-xs middle-xs item">
                                    <a href="{{ route('register',app()->getLocale()) }}" style="text-decoration: none;" class="social-icon mr-2 ml-2" >
                                        <i class="material-icons mat-icon-sm">person</i>
                                        <span class="px-1">{{__('sign_up_title')}}</span>
                                    </a>
                                </span>
                                <span class="d-flex center-xs middle-xs item">
                                    <a href="{{ route('login',app()->getLocale()) }}" style="text-decoration: none;" class="social-icon mr-2 ml-2">
                                        <i class="material-icons mat-icon-sm">login</i>
                                        <span class="px-1">{{__('login_title')}}</span>
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="main-toolbar" class="mdc-elevation--z2">
            <div class="theme-container row between-xs middle-xs h-100">
                <a href="{{ route('Main.index', ['locale' => app()->getLocale()]) }}" class="logo d-flex">
                    <img src="{{ asset('images/main/logo_header_' . app()->getLocale() . '.png') }}" alt="image" style="max-height: 60px;margin: 5px 0;" id="logo_header">
                </a>
                <div class="horizontal-menu d-none d-md-flex d-lg-flex d-xl-flex">
                    <div>
                        <a href="{{'/'.app()->getLocale(). '/' }}" class="mdc-button"  style="{{Route::currentRouteName() == 'Main.index' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">{{__('home_title')}}</span>
                        </a>
                    </div>
                    <div>
                        <a href="{{'/'.app()->getLocale(). '/required' }}" class="mdc-button" style="{{Route::currentRouteName() == 'required_for_rent' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">{{__('required_for_rent')}}</span>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('companies', app()->getLocale()) }}" class="mdc-button" style="{{Route::currentRouteName() == 'companies' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">{{__('companies')}}</span>
                        </a>
                    </div>
                    <div>
                        <a href="{{ '/'.app()->getLocale().'/aboutus' }}" class="mdc-button" style="{{Route::currentRouteName() == 'Main.aboutus' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">{{__('about_us_title')}}</span>
                        </a>
                    </div>
                    <div>
                        <a href="{{ '/'.app()->getLocale().'/contact' }}" class="mdc-button" style="{{Route::currentRouteName() == 'Message.create' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">{{__('contact_title')}}</span>
                        </a>
                    </div>
                    <div>
                        @if ( app()->getLocale() == "en")
                            <span onclick="changeLng('ar')" class="mdc-button">
                                <span class="mdc-button__ripple"></span>
                                <span class="mdc-button__label">العربیه</span>
                            </span>
                        @else
                            @if(env('ENGLISH_BUTTON', false))
                                <span onclick="changeLng('en')" class="mdc-button">
                                    <span class="mdc-button__ripple"></span>
                                    <span class="mdc-button__label">English</span>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row middle-xs" @if(in_array(request()->route()->getName(), ['Main.aboutus', 'Message.create', 'companies.info', 'site.ad.detail'])) style="visibility: hidden" @endif>
{{--                    <a href="{{route('site.advertising.create', app()->getLocale())}}" class="mdc-fab mdc-fab--mini primary d-sm-flex d-md-none d-lg-none d-xl-none">--}}
{{--                        <span class="mdc-fab__ripple"></span>--}}
{{--                        <span class="mdc-fab__icon material-icons">add</span>--}}
{{--                    </a>--}}
                    <a href="{{route('site.advertising.create', app()->getLocale())}}" class="mdc-button mdc-button--raised d-none d-sm-none d-md-flex d-lg-flex d-xl-flex">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{ __('add_listing_title') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
