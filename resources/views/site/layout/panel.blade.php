@extends('site.layout.master')
@section('content')
    <main>
        <div class="px-3">
            <div class="theme-container">
                <div class="page-drawer-container mt-3">
                    <aside class="mdc-drawer mdc-drawer--modal page-sidenav">
                        <a href="#" class="h-0"></a>
                        <div class="mdc-card">
                            <div class="row start-xs middle-xs p-3">
                                <img src="{{ is_file(public_path(auth()->user()->image_profile)) ? asset(auth()->user()->image_profile) : asset('asset/assets/images/others/user.jpg') }}" alt="user-image" class="avatar">
                                <h2 class="text-muted fw-500 mx-3">@if(auth()->user()->name){{ auth()->user()->name }}@else<a href="{{ route('Main.profile',app()->getLocale()) }}">{{ __('update_name') }}</a>@endif</h2>
                            </div>
                            <hr class="mdc-list-divider m-0">
                            <ul class="mdc-list">
                                <li>
                                    <a href="{{ route('Main.buyPackage',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "buypackage") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="mdc-list-item__graphic material-icons text-muted mx-3">add_circle</i>
                                        <span class="mdc-list-item__text">{{__('buy_package_title')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Main.myAds',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "myads") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="mdc-list-item__graphic material-icons text-muted mx-3">home</i>
                                        <span class="mdc-list-item__text">{{__('my_ads_title')}}</span>
                                    </a>
                                </li>
                                @if(env('PACKAGE_HISTORY', false))
                                    <li>
                                        <a href="{{ route('Main.paymentHistory',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "paymenthistory") background-color: var(--mdc-theme-primary); color: white; @endif">
                                            <i class="mdc-list-item__graphic material-icons text-muted mx-3">compare_arrows</i>
                                            <span class="mdc-list-item__text">{{__('package_history_title')}}</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('Main.profile',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "profile") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="mdc-list-item__graphic material-icons text-muted mx-3">edit</i>
                                        <span class="mdc-list-item__text">{{__('edit_profile_title')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Main.changePassword',app()->getLocale()) }}" class="mdc-list-item" role="menuitem" style="@if(collect(request()->segments())->last() == "changepassword") background-color: var(--mdc-theme-primary); color: white; @endif">
                                        <i class="mdc-list-item__graphic material-icons text-muted mx-3">lock</i>
                                        <span class="mdc-list-item__text">{{__('change_password_title')}}</span>
                                    </a>
                                </li>
                                <li role="separator" class="mdc-list-divider m-0"></li>
                                <li>
                                    <a href="#" class="mdc-list-item" role="menuitem" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="mdc-list-item__graphic material-icons text-muted mx-3">power_settings_new</i>
                                        <span class="mdc-list-item__text">{{__('Logout')}}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <div class="mdc-drawer-scrim page-sidenav-scrim"></div>
                    <div class="page-sidenav-content">
{{--                        <div class="row mdc-card between-xs middle-xs w-100 p-2 mdc-elevation--z1 text-muted d-md-none d-lg-none d-xl-none mb-3">--}}
{{--                            <button id="page-sidenav-toggle" class="mdc-icon-button material-icons">more_vert</button>--}}
{{--                            <h3 class="fw-500">{{ __('my_account_title') }}</h3>--}}
{{--                        </div>--}}
                        <div class="mdc-card p-3 sm:px-2">
                            @yield('panel-content')
                        </div>
                        @hasSection('pagination')
                        <div class="row center-xs middle-xs my-3 w-100">
                            <div class="mdc-card w-100">
                                @yield('pagination')
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
