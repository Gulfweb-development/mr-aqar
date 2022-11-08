@extends('site.layout.master')
@section('title' , __('companies'))
@php
    $side = app()->getLocale() === 'en' ? 'r' : 'l';
@endphp

@section('content')

    <style>
        .whatsapp-icon {
            color: #4caf50;
            display: inline-block;
            /* transform: translateY(-2px); */
        }
    </style>
    <main class="content-offset-to-top">
        <div class="theme-container">
            @auth()
                <div class="row">
                    @if(auth()->user()->type_usage === 'company')
                        <form action="{{ route('companies.downgrade',app()->getLocale()) }}" method="post" id="downForm">@csrf
                        </form>

                        @php
                            $first = __('account_to_individual_alert');
                            $second = __('are_you_sure');
                            $confirmJs = "confirm(`{$first}\n{$second}`) ? $(`#downForm`).submit() : null";
                            $companyRoute = route('companies.info',
                            [app()->getLocale(),auth()->user()->company_phone,auth()->user()->company_name]);
                            $cardMessage = '<a href="'. $companyRoute .'" class="links">' . __('see_your_company') . '</a>'
                            . '<br>' . '<a onclick="'. $confirmJs .'" class="center-xs d-block links pointer-cursor">' . __('downgrade_account') .
                                '</a>'; @endphp
                        {{-- @elseif($balance !== 0)
                        @php $cardMessage = __('already_have_package'); @endphp --}}
                    @endif
                    <div class="col-xs-11 col-sm-7 col-md-5 my-1 mx-auto my-3">
                        <div class="card card-subscribe card-buy shadow companies-card rounded">
                            <div class="card-body p-3">
                                <div class="row">
                                    @isset($cardMessage)
                                        <div class="{{ (\App\Http\Controllers\site\MessageController::getSettingDetails('on_top_price') > 0 && ! auth()->user()->is_premium && auth()->user()->type_usage === 'company') ? 'col-md-6' : 'col-md-12' }} col-xs-12 flex-container text-center">
                                            <p class="fw-600 mx-auto">{!! $cardMessage !!}</p>
                                        </div>
                                        @if(\App\Http\Controllers\site\MessageController::getSettingDetails('on_top_price') > 0 && ! auth()->user()->is_premium && auth()->user()->type_usage === 'company')
                                            <div class="col-md-6 col-xs-12 text-center">
                                                <div class="decoration-none mb-2 p-2 text-white" style="background: #A47E01;">{{ \App\Http\Controllers\site\MessageController::getSettingDetails('on_top_price') }} {{ __('kd_title') }}</div>
                                                <a class="decoration-none text-white" href="{{ route('buyPremium', app()->getLocale()) }}">
                                                    <div class="row">
                                                <span class="col-md-3 col-xs-3 p-0" style="background-color: black;" >
                                                    <img style="width: 68% !important;margin-top: 9px;" src="{{ asset('asset/images/one.png') }}">
                                                </span>
                                                        <span class="col-md-9 col-xs-9 flex-container font-1rem fw-500 justify-center p-0" style="background-color: #7092BF">{{__('buy_premium')}}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-4 col-xs-5 p-0">
                                            <img src="{{route('image.upgrade-company', '')}}" alt="upgrade"
                                                 class="w-100 d-block rounded">
                                        </div>
                                        <div class="col-md-8 col-xs-7 center-xs p-0 pl-3 company-card-body">
                                            <p class="mb-3 fw-600">{{__('upgrade_account')}}</p>

                                            <a href="{{ route('companies.new', app()->getLocale()) }}"
                                               class="mdc-button mdc-button--raised w-90 mx-auto sm-button-mobile">
                                                <span class="mdc-button__ripple"></span>
                                                <span class="mdc-button__label">{{__('do_upgrade')}}</span>
                                            </a>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">--}}
                {{-- <a href="{{ '/'.app()->getLocale().'/contact' }}"
                    class="fw-500 text-muted mx-auto">{{__('call_for_assist')}}</a>--}}
                {{-- </div>--}}
            @endauth
            <div class="row">
                <h1 class="fw-600 mx-auto py-3">{{__('companies_list')}}</h1>
            </div>
            <div class="row md:px-5 justify-content-center col-">
                @foreach($companies as $company)
                    <div class="card-mobile-tablet col-md-2 col-sm-12 col-xs-12 px-1">
                        <div class="card card-subscribe card-buy shadow companies-card rounded  p-0 sm:m{{$side}}-2 mb-3"
                             style="height: max-content">
                            <div class="card-body p-3 sm:p-1.5">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 col-md-4 col-sm-4 col-xs-4 pt-3">
                                        <a href="{{route('companies.info', [app()->getLocale(),$company->company_phone,$company->company_name])}}"
                                           class="company-img h-100 mx-auto">
                                            <img style="object-fit: cover"
                                                 src="{{ is_file(public_path($company->image_profile)) ? asset($company->image_profile) : asset('asset/assets/images/others/user.jpg') }}"
                                                 alt="agent-image"
                                                 class="mw-100 md:w-100 d-block rounded small-only-max-height max-height h-100">
                                        </a>
                                    </div>
                                    <div class="center-xs col-md-12 col-md-8 col-sm-8 col-xs-8 p-0">
                                        <div class="row sm:py-4">
                                            <div class="col-md-12 col-xs-6 col-sm-6">
                                                @php
                                                    $tel = \Illuminate\Support\Str::startsWith($company->company_phone, '+') ?
                                                    $company->company_phone : "+{$company->company_phone}";
                                                    $tel = \Illuminate\Support\Str::startsWith($tel, '+965') ? $tel : str_replace('+',
                                                    '+965', $tel);
                                                    $tel = str_replace(' ', '', $tel);
                                                @endphp
                                                <a href="{{route('companies.info', [app()->getLocale(),$company->company_phone,$company->company_name])}}"
                                                   class="align-items-center company-name d-flex fw-600 justify-content-center line-height-sm links my-1 pt-2 sm:py-4 text-body">{{ @$company->company_name }}</a>

                                                <a href="tel:{{ $tel }}" class="text-danger decoration-none d-block mb-2">
                                                    <strong class="mdc-button__label">{{ $company->company_phone }}</strong>
                                                </a>
                                            </div>
                                            <div class="col-md-12 col-sm-6 col-xs-6 sm:py-4">
                                                <div class="company-socials-container">
                                                    @if(count($company->socials))
                                                        @foreach($company->socials as $social)
                                                            @if($social->type == 'instagram')
                                                                <a class="decoration-none"
                                                                   href="{{ \Illuminate\Support\Str::contains($social->address, ['http://','https://']) ? $social->address : "
                                        https://www.instagram.com/".str_replace('@', '' , $social->address) }}"
                                                                   target="_blank">
                                                                    <svg class="material-icons mat-icon-md company-social" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                              d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
                                                                    </svg>
                                                                </a>
                                                            @elseif($social->type === 'twitter')
                                                                <a class="decoration-none"
                                                                   href="{{ \Illuminate\Support\Str::contains($social->address, ['http://','https://']) ? $social->address : "
                                        https://twitter.com/".str_replace('@', '' , $social->address) }}"
                                                                   target="_blank">
                                                                    <svg class="material-icons mat-icon-md company-social" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                              d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 3,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16 6,17.26 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.79C20.33,8.6 20.33,8.42 20.32,8.23C21.16,7.63 21.88,6.87 22.46,6Z" />
                                                                    </svg>
                                                                </a>
                                                            @elseif($social->type === 'email')
                                                                <a class="decoration-none" href="mailto:{{$social->address}}" target="_blank">
                                                                    <svg class="material-icons mat-icon-md company-social" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                              d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                                                                    </svg>
                                                                </a>
                                                            @elseif($social->type === 'facebook')
                                                                <a class="decoration-none"
                                                                   href="{{ \Illuminate\Support\Str::contains($social->address, ['http://','https://']) ? $social->address : "
                                        https://www.facebook.com/".str_replace('@', '' , $social->address) }}"
                                                                   target="_blank">
                                                                    <svg class="material-icons mat-icon-md company-social" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                              d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
                                                                    </svg>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    <a class="decoration-none whatsapp-icon"
                                                       href="https://api.whatsapp.com/send?phone={{str_replace('+', '', $tel)}}&text={{ @route('companies.info', [app()->getLocale(),$company->company_phone,$company->company_name]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                            <path
                                                                d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                        </svg>
                                                        <p>{{ __('whatsapp') }}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

@endsection
