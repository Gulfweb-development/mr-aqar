@extends('site.layout.master')

@isset($company)
    @section('title', $company->company_name . ' | ' . $company->company_phone)
@endisset
@isset($required_for_rent)
    @section('title', __('required_for_rent_page_title'))
@endisset
@section('meta')
    <meta name="description" content="{{\App\Http\Controllers\site\MessageController::getSettingDetails('home_description_' . app()->getLocale())}}">
    <meta name="keywords" content="{{\App\Http\Controllers\site\MessageController::getSettingDetails('keywords_' . app()->getLocale())}}">
@endsection

@php
$side = app()->getLocale() === 'en' ? 'r' : 'l';
$unSide = app()->getLocale() === 'en' ? 'l' : 'r';
@endphp
@section('content')

    <main>
        @isset($company)
            @include('site.sections.company-info')
        @endisset
        <div class="px-3">
            <div class="theme-container" id="app" @isset($company) data-company="{{$company->id}}" @endisset data-requiredPage="{{ isset($required_for_rent) ? '1' : '0' }}"  data-locale="{{app()->getLocale()}}">

                @isset($company)
                        <h2>{{__('company_ads')}}</h2>
                @endisset

{{--                <div class="mt-5"></div>--}}

                @if(! isset($company))
                    @include('site.sections.search')
                @endif

                <div class="center-xs">
                    <h3 v-if="notFound && newAds" class="alert alert-danger text-center mt-2"><strong>{{__('norecord')}}</strong></h3>
                    <h3 v-if="notFound && newAds" class="alert text-center mt-2"><strong>{{__('showing_new_ads')}}</strong></h3>
                </div>

                @include('site.sections.card')

                <div class="center-xs" id="pageEnd">
                    <img v-if="isLoading !== false" src="{{asset('images/main/loading.gif')}}" alt="loading" class="loading">
{{--                    <h3 v-else-if="noMore" class="mt-2">{{__('no_more_ads')}}</h3>--}}
                    <h3 v-else-if="notFound && !newAds" class="alert alert-danger text-center mt-2"><strong>{{__('norecord')}}</strong></h3>
                </div>

            </div>
        </div>
    </main>

    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        .image-box::before {
            content: "";
            position: absolute;
            @if(app()->getLocale() === 'en') left @else right @endif : -5px;
            top: 1.27rem;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-{{app()->getLocale() === 'en' ? 'right' : 'left' }}: 5px solid var(--badge);
            font-size: .875rem;
        }
        .image-box::after {
            content: "{{__('premium_short')}}";
            position: absolute;
            @if(app()->getLocale() === 'en') left @else right @endif : -5px;
            top: 0;
            background: var(--badge);
            border-radius: 2px 2px 0 2px;
            padding: .09rem .6rem;
            color: #fff;
            font-size: .8rem;
        }
    </style>

@endsection
