@php
$bannerFile =\App\Http\Controllers\site\MessageController::getSettingDetails('header_banner') ;
@endphp
@if( ! isset($hideHeaderAndFooter) or  ( isset($hideHeaderAndFooter) and !$hideHeaderAndFooter) )
@if($bannerFile and is_file(public_path($bannerFile)) and ( isset($_GET['banner']) or true ) )
    <aside class="d-mobile-none1" style="margin: 0;width: 100%;-webkit-box-pack: justify;-ms-flex-pack: justify;justify-content: space-between;">
        <a href="{{ \App\Http\Controllers\site\MessageController::getSettingDetails('banner_link') ? \App\Http\Controllers\site\MessageController::getSettingDetails('banner_link') : "#" }}" style="background-image: url('{{ asset($bannerFile) }}');margin: 0;height: 60px;border-radius: 0;background-size: cover;background-repeat: no-repeat;background-position: 50%;width: 100%;display: block;-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;"></a>
    </aside>
@endif
<aside class="mdc-drawer mdc-drawer--modal sidenav" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!}
style="z-index: 99999">
    <div class="row end-xs middle-xs py-1 px-3 justify-content-between" style="background: #43414e">
        <a href="{{ route('Main.index', ['locale' => app()->getLocale()]) }}" class="logo d-flex">
            <img src="{{ asset('images/main/logo_footer_' . app()->getLocale() . '.png') }}" alt="image"
                 style="width: 70px;margin: 5px 0;" id="logo_header">
        </a>
        <button id="sidenav-close" class="mdc-icon-button material-icons warn-color text-white">close</button>
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
                @if (!request()->is(app()->getLocale().'/required'))
                    <a href="{{route('site.advertising.create', app()->getLocale())}}"
                       class="mdc-button mdc-button--raised mb-4 mt-3 text-white"
                       style="color: white; background: #ff7e22; {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                        <span class="mdc-button__ripple"></span>
                        @if ( app()->getLocale() == "ar")
                            <i class="material-icons mdc-button__icon">add</i>
                            <span class="mdc-button__label">{{ __('add_listing_title') }}</span>
                        @else
                            <span class="mdc-button__label">{{ __('add_listing_title') }}</span>
                            <i class="material-icons mdc-button__icon" style="margin-left: 0;margin-right: 8px;">add</i>
                        @endif
                    </a>
                @endif

            </div>
            <div>
                <a href="{{'/'.app()->getLocale(). '/' }}" class="mdc-button"
                   style="{{Route::currentRouteName() == 'Main.index' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    @if ( app()->getLocale() == "ar")
                        <i class="material-icons mdc-button__icon">home</i>
                        <span class="mdc-button__label">{{__('home_title')}}</span>
                    @else
                        <span class="mdc-button__label">{{__('home_title')}}</span>
                        <i class="material-icons mdc-button__icon" style="margin-left: 0;margin-right: 8px;">home</i>
                    @endif
                </a>
            </div>

            @if(auth()->check())

            @else
                <div>
                    <a href="{{ route('login',app()->getLocale()) }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'login' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                        <span class="mdc-button__ripple"></span>
                        @if ( app()->getLocale() == "ar")
                            <i class="material-icons mdc-button__icon">login</i>
                            <span class="mdc-button__label">{{__('login_title')}}</span>
                        @else
                            <span class="mdc-button__label">{{__('login_title')}}</span>
                            <i class="material-icons mdc-button__icon" style="margin-left: 0;margin-right: 8px;">login</i>
                        @endif
                    </a>
                </div>
            @endif
            <div>
                <a href="{{'/'.app()->getLocale(). '/required' }}" class="mdc-button"
                   style="{{Route::currentRouteName() == 'required_for_rent' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">{{ __('required_for_rent')}}</span>
                </a>
            </div>
            <div>
                <a href="{{'/'.app()->getLocale(). '/advertising?purpose=rent' }}"
                   class="d-inline-block d-lg-none mdc-button"
                   style="{{Route::currentRouteName() == 'rent' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">{{__('rent').' '. __('in_kuwait') }}</span>
                </a>
            </div>
            <div>
                <a href="{{'/'.app()->getLocale(). '/advertising?purpose=sell' }}"
                   class="d-inline-block d-lg-none mdc-button"
                   style="{{Route::currentRouteName() == 'sell' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">{{__('sell').' '. __('in_kuwait') }}</span>
                </a>
            </div>
            <div>
                <a href="{{'/'.app()->getLocale(). '/advertising?purpose=exchange' }}"
                   class="d-inline-block d-lg-none mdc-button"
                   style="{{Route::currentRouteName() == 'exchange' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">{{__('exchange').' '. __('in_kuwait') }}</span>
                </a>
            </div>
            <div>
                <a href="{{ route('companies', app()->getLocale()) }}" class="mdc-button d-inline-block d-lg-none"
                   style="{{Route::currentRouteName() == 'companies' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}} {{ app()->getLocale() == "ar" ? 'justify-content: right !important;' : '' }}">
                    <span class="mdc-button__ripple"></span>
                    @if ( app()->getLocale() == "ar")
                        <i class="material-icons mdc-button__icon">work</i>
                        <span class="mdc-button__label">{{__('companies') }}</span>
                    @else
                        <span class="mdc-button__label">{{__('companies') }}</span>
                        <i class="material-icons mdc-button__icon" style="margin-left: 0;margin-right: 8px;">work</i>
                    @endif
                </a>
            </div>
            {{-- <div>--}}
            {{-- <a href="{{ '/'.app()->getLocale().'/aboutus' }}" class="mdc-button"
                style="{{Route::currentRouteName() == 'Main.aboutus' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">--}}
            {{-- <span class="mdc-button__ripple"></span>--}}
            {{-- <span class="mdc-button__label">{{__('about_us_title')}}</span>--}}
            {{-- </a>--}}
            {{-- </div>--}}
            {{-- <div>--}}
            {{-- <a href="{{ '/'.app()->getLocale().'/contact' }}" class="mdc-button"
                style="{{Route::currentRouteName() == 'Message.create' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">--}}
            {{-- <span class="mdc-button__ripple"></span>--}}
            {{-- <span class="mdc-button__label">{{__('contact_title')}}</span>--}}
            {{-- </a>--}}
            {{-- </div>--}}
            <div>
                @if ( app()->getLocale() == "en")
                    <span onclick="changeLng('ar')" class="mdc-button" style="justify-content: right !important;">
                    <span class="mdc-button__ripple"></span>
                    <i class="material-icons mdc-button__icon">language</i>
                    <span class="mdc-button__label">العربیه</span>
                </span>
                @else
                    @if(env('ENGLISH_BUTTON', false))
                        <span onclick="changeLng('en')" class="mdc-button">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label">English</span>
                    <i class="material-icons mdc-button__icon">language</i>
                </span>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="row center-xs middle-xs py-3">
        @include('site.sections.socials', ['icon_classes' => 'mat-icon-md primary-color', 'sidebar' => true])
        <hr class="m-2 mdc-list-divider w-100">
        <div class="w-100 text-center">
            @if(\App\Http\Controllers\site\MessageController::getSettingDetails('ios_link') )
                <a href="{{ \App\Http\Controllers\site\MessageController::getSettingDetails('ios_link')  }}" target="_blank" style="display: inline-block;    color: inherit;width: 40%;">
                    <img src="{{ asset('asset/images/App-Store-Button-300x98.png') }}" style="width: 100%;">
                </a>
            @endif
            @if(\App\Http\Controllers\site\MessageController::getSettingDetails('android_link') )
                <a href="{{ \App\Http\Controllers\site\MessageController::getSettingDetails('android_link')  }}" target="_blank" style="display: inline-block;    color: inherit;width: 40%;">
                    <img src="{{ asset('asset/images/Google-Play-Store-Button-300x98.png') }}" style="width: 100%;">
                </a>
            @endif
        </div>
    </div>
</aside>
<div class="mdc-drawer-scrim sidenav-scrim"></div>
<header class="toolbar-1 {{ ($header ?? '') !== 'transparent' ?: 'has-bg-image' }}"
        dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
    <div id="top-toolbar" class="mdc-top-app-bar">
        <div class="theme-container row between-xs middle-xs h-100">
            <div class="row d-lg-none start-xs middle-xs">
                <button id="sidenav-toggle" class="mdc-button mdc-ripple-surface d-md-none d-lg-none d-xl-none">
                    <span class="mdc-button__ripple"></span>
                    <i class="material-icons" style="font-size: 42px;">menu</i>
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
                        <div class="mdc-menu mdc-menu-surface user-menu" {!! app()->getLocale() === 'ar' ? ' dir="rtl"'
                        : '' !!}>
                            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical" tabindex="-1">
                                <li class="user-info row start-xs middle-xs">
                                    <img src="{{ is_file(public_path(auth()->user()->image_profile)) ? asset(auth()->user()->image_profile) : asset('asset/assets/images/others/user.jpg') }}"
                                         alt="user-image" width="50">
                                    <p class="m-0">@if(auth()->user()->name){{ auth()->user()->name }}@else<a
                                            href="{{ route('Main.profile',app()->getLocale()) }}">{{ __('update_name')
                                        }}</a>@endif<br>
                                        {{-- <a href="{{url(app()->getLocale().'/paymenthistory')}}" class="text_blue"
                                            style="color:#088dd3;text-decoration:none;">--}}
                                        @if($balance == 0) 0 {{__('ads_title')}}
                                        @else
                                            <span class="">
                                            {{ $balance['available'] }} {{__('ads_title')}}
                                        </span>
                                            <span class="@if( app()->getLocale() == " ar" ) mr-3 @else ml-3 @endif">
                                            {{ $balance['available_premium'] }} {{__('premium_short')}}
                                        </span>
                                        @endif
                                        {{-- </a>--}}
                                    </p>

                                </li>
                                <li role="separator" class="mdc-list-divider m-0"></li>
                                <li>
                                    <a href="{{ route('Main.buyPackage',app()->getLocale()) }}" class="mdc-list-item"
                                       role="menuitem" style="@if(collect(request()->segments())->last() == " buypackage")
                                    background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted ">add_circle</i>
                                        <span class="mdc-list-item__text px-3">{{__('buy_package_title')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Main.myAds',app()->getLocale()) }}" class="mdc-list-item"
                                       role="menuitem" style="@if(collect(request()->segments())->last() == " myads")
                                    background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted">home</i>
                                        <span class="mdc-list-item__text px-3">{{__('my_ads_title')}}</span>
                                    </a>
                                </li>
                                @if(env('PACKAGE_HISTORY', false))
                                    <li>
                                        <a href="{{ route('Main.paymentHistory',app()->getLocale()) }}" class="mdc-list-item"
                                           role="menuitem" style="@if(collect(request()->segments())->last() == "
                                    paymenthistory") background-color: var(--mdc-theme-primary); color: white; @endif">
                                            <i class="material-icons mat-icon-sm text-muted">compare_arrows</i>
                                            <span class="mdc-list-item__text px-3">{{__('package_history_title')}}</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('Main.profile',app()->getLocale()) }}" class="mdc-list-item"
                                       role="menuitem" style="@if(collect(request()->segments())->last() == " profile")
                                    background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="material-icons mat-icon-sm text-muted">edit</i>
                                        <span class="mdc-list-item__text px-3">{{__('edit_profile_title')}}</span>
                                    </a>
                                </li>
                                {{--                            <li>--}}
                                {{--                                <a href="{{ route('Main.changePassword',app()->getLocale()) }}" class="mdc-list-item"--}}
                                {{--                                    role="menuitem" style="@if(collect(request()->segments())->last() == "--}}
                                {{--                                    changepassword") background-color: var(--mdc-theme-primary); color: white; @endif">--}}
                                {{--                                    <i class="material-icons mat-icon-sm text-muted">lock</i>--}}
                                {{--                                    <span class="mdc-list-item__text px-3">{{__('change_password_title')}}</span>--}}
                                {{--                                </a>--}}
                                {{--                            </li>--}}
                                {{--                            <li>--}}
                                {{--                                <a href="/{{ app()->getLocale() }}/user/delete" class="mdc-list-item"--}}
                                {{--                                    role="menuitem" style="@if(collect(request()->segments())->last() == "--}}
                                {{--                                    changepassword") background-color: var(--mdc-theme-primary); color: white; @endif">--}}
                                {{--                                    <i class="material-icons mat-icon-sm text-muted">delete</i>--}}
                                {{--                                    <span class="mdc-list-item__text px-3">{{  __('delete') .' '. __('account')}}</span>--}}
                                {{--                                </a>--}}
                                {{--                            </li>--}}
                                <li role="separator" class="mdc-list-divider m-0"></li>
                                <li>
                                    <a href="#" class="mdc-list-item" role="menuitem" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="material-icons mat-icon-sm text-muted">power_settings_new</i>
                                        <span class="mdc-list-item__text px-3">{{__('Logout')}}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="row start-xs middle-xs fw-500 d-md-flex d-lg-flex d-xl-flex">
                        <span class="d-flex center-xs middle-xs item">
                            <a href="{{ route('register',app()->getLocale()) }}" style="text-decoration: none;"
                               class="social-icon mr-2 ml-2">
                                <i class="material-icons mat-icon-sm">person</i>
                                <span class="px-1">{{__('sign_up_title')}}</span>
                            </a>
                        </span>
                            <span class="d-flex center-xs middle-xs item">
                            <a href="{{ route('login',app()->getLocale()) }}" style="text-decoration: none;"
                               class="social-icon mr-2 ml-2">
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
                <img src="{{ asset('images/main/logo_header_' . app()->getLocale() . '.png') }}" alt="image"
                     style="max-height: 60px;margin: 5px 0;" id="logo_header">
            </a>
            <div class="horizontal-menu d-none d-md-flex d-lg-flex d-xl-flex">
                <div>
                    <a href="{{'/'.app()->getLocale(). '/' }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'Main.index' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('home_title')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{'/'.app()->getLocale(). '/required' }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'required_for_rent' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('required_for_rent')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{ route('companies', app()->getLocale()) }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'companies' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('companies')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{ '/'.app()->getLocale().'/aboutus' }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'Main.aboutus' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{__('about_us_title')}}</span>
                    </a>
                </div>
                <div>
                    <a href="{{ '/'.app()->getLocale().'/contact' }}" class="mdc-button"
                       style="{{Route::currentRouteName() == 'Message.create' ? 'background-color: var(--mdc-theme-primary); color: #fff;' : ''}}">
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
            <div class="row middle-xs" @if(in_array(request()->route()->getName(), ['Main.aboutus',
                'Message.create', 'companies.info', 'site.ad.detail'])) style="visibility: hidden" @endif>
                {{-- <a href="{{route('site.advertising.create', app()->getLocale())}}"
                    class="mdc-fab mdc-fab--mini primary d-sm-flex d-md-none d-lg-none d-xl-none">--}}
                {{-- <span class="mdc-fab__ripple"></span>--}}
                {{-- <span class="mdc-fab__icon material-icons">add</span>--}}
                {{-- </a>--}}
                @if (!request()->is(app()->getLocale().'/required'))
                    <a href="{{route('site.advertising.create', app()->getLocale())}}"
                       class="mdc-button mdc-button--raised center d-none d-lg-flex"
                       style="color: white; background: #ff7e22">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label">{{ __('add_listing_title') }}</span>
                        <i class="material-icons mdc-button__icon">add</i>
                    </a>
                @endif

            </div>
        </div>
    </div>
</header>
@endif
