@extends('site.layout.master')
@section('title' , __('buy_package_title'))
@section('content')

@if((session('status')) == 'success')
<div class="alert alert-success">
    <strong>{{ __('success_title') }}!</strong> {{__('packageSuccessBuy')}}!
</div>
@elseif((session('status')) == 'validation_failed')
<div class="alert alert-danger">
    <strong>{{__('un_success_title')}}!</strong> {{__('wrongInput')}}!
</div>
@elseif((session('status')) == 'account_upgraded')
<div class="alert alert-success">
    <strong>{{__('success_title')}}!</strong> {{__('upgraded_to_company')}}!
</div>
@elseif((session('status')) == 'ads_remaining')
<div class="alert alert-danger">
    <strong>{{__('un_success_title')}}!</strong> {{__('packageNotFinished')}}!
</div>
@elseif((session('status')) == 'account_downgraded')
<div class="alert alert-success">
    <strong>{{__('success_title')}}!</strong> {{__('account_downgraded_successfully')}} !
</div>
@elseif((session('status')) == 'unsuccess')
<div class="alert alert-danger">
    <strong>{{__('un_success_title')}}!</strong> {{__('un_success_alert_title')}}!
</div>
@elseif((session('status')) == 'have_no_package')
<div class="alert alert-danger">
    {{ __('have_no_package') }}
</div>
@endif
<style>
    :root {
        --mdc-theme-secondary: #E91E63 !important; // radio buttons
    }
</style>
<main>
    <div class="px-3">
        <div class="theme-container">
            <div class="my-5">

                @if ( ! env('NORMAL_ADS_FREE' , false) )
                <div class="col-xs-11 col-sm-7 col-md-4 my-1 mx-auto mb-2">
                    <div class="card card-subscribe card-buy companies-card rounded">
                        <div class="card-body p-3">
                            <div class="row">
                                <p class="w-100 center-xs text-md fw-600">{{__('balance')}}</p>
                                <div class="d-flex justify-evenly w-100 px-3">
                                    <p class="primary-color fw-600">{{ $credit['count_normal_advertising'] }}
                                        {{__('ads_title')}}</p>
                                    <p class="primary-color fw-600">{{ $credit['count_premium_advertising'] }}
                                        {{__('premium_short')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="column center-xs middle-xs text-center">
                    <h1 class="uppercase">{{__('buy_package_title')}}</h1>
                    <p class="text-muted fw-500">{{__('subscribetoourpackagenote')}}</p>
                </div>

                <div class="mdc-tab-bar-wrapper centered pricing-tabs">
                    @if ( ! env('NORMAL_ADS_FREE' , false) )
                    <div class="mdc-tab-bar mb-3">
                        <div class="mdc-tab-scroller">
                            <div class="mdc-tab-scroller__scroll-area">
                                <div class="mdc-tab-scroller__scroll-content">
                                    <button class="mdc-tab mdc-tab--active" tabindex="0">
                                        <span class="mdc-tab__content">
                                            <span class="mdc-tab__text-label text-xs fw-600">{{__('payasyougo')}}</span>
                                        </span>
                                        <span class="mdc-tab-indicator mdc-tab-indicator--active">
                                            <span
                                                class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                        </span>
                                        <span class="mdc-tab__ripple"></span>
                                    </button>
                                    <button class="mdc-tab mdc-tab" tabindex="0">
                                        <span class="mdc-tab__content">
                                            <span
                                                class="mdc-tab__text-label text-xs fw-600">{{__('longtermsubscribe')}}</span>
                                        </span>
                                        <span class="mdc-tab-indicator mdc-tab-indicator">
                                            <span
                                                class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                        </span>
                                        <span class="mdc-tab__ripple"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="tab-content tab-content--active">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 p-2">
                                <div class="row ">
                                    @csrf
                                    <div style="width: 50%">
                                        <div class="mdc-card pricing-card text-center  p-0 h-100">
                                            <div class="bg-primary pricing-header py-4">
                                                <h2 class="">{{ __("free_ad") }}</h2>
                                            </div>
                                            <div class="px-2 ad-plan-bottom">

                                                <div>
                                                    <input type="hidden" class="form-control" name="payment_type"
                                                        value="CBKPay">
                                                    <div
                                                        class="mdc-text-field mdc-text-field--outlined w-100 custom-field mb-3">
                                                        
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 50%">
                                        <div class="c w-100" style="height: calc(100% - 40px)">
                                            <div class="text-center f-d-column">
                                                <div class="d-block pb-2">
                                                    <div class="c">
                                                        <a href="/{{ app()->getLocale() }}/advertising/create"
                                                            class="pe-auto text-decoration-none bg-orange rounded-full ar-eq w-40px c d-inline-block mx-auto">
                                                            <i class="material-icons text-white">add</i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>{{ __('free_ad') }}</p>
                                            </div>
                                        </div>
                                        <div class="w-100 px-2" style="height: 40px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($statics as $static)
                            <div class="col-xs-12 col-sm-12 col-md-6 p-2">
                                <form method="post" action="{{ route('Main.buyPackageOrCredit',app()->getLocale()) }}"
                                    class="row ">
                                    @csrf
                                    <div style="width: 50%">
                                        <div class="mdc-card pricing-card text-center border-accent p-0 h-100">
                                            <div class="bg-accent pricing-header px-2">
                                                <h1 class="fs-sm-20">@if( $static->old_price > $static->price ) <small>
                                                        <span class="del opacity-70">{{ $static->old_price }} </span>
                                                    </small> @endif {{$static->price }}<small> {{__('kd_title')}}
                                                        <br>
                                                        {{-- {{ app()->getLocale()=="en" ? $static->title_en :
                                                        $static->title_ar }} --}}
                                                        {{-- /{{ $static->count_day }} {{__('days')}} --}}</small></h1>
                                                <p class="desc mb-2">
                                                    @if(app()->getLocale()=="en"){{$static->title_en}}@else{{$static->title_ar}}@endif
                                                </p>
                                            </div>
                                            <div class="px-2 ad-plan-bottom">
                                                <p class=" add-plan-description">
                                                    @if(app()->getLocale()=="en"){{$static->description_en}}@else{{$static->description_ar}}@endif
                                                </p>

                                                <div>
                                                    <input type="hidden" class="form-control" name="payment_type"
                                                        value="CBKPay">
                                                    <div
                                                        class="mdc-text-field mdc-text-field--outlined w-100 custom-field mb-3">
                                                        <input type="number" value="1" min="1"
                                                            class="mdc-text-field__input"
                                                            placeholder="{{__('noofads')}}" name="count" id="{{ "
                                                            static-num-" . $static->id }}" required>
                                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label class="mdc-floating-label"
                                                                    style="">{{__('noofads')}}</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" value="static">
                                                <input type="hidden" name="package_id" value="{{ $static->id }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 50%">
                                        <div class="c w-100 " style="height: calc(100% - 40px)">
                                            <div class="text-center f-d-column">
                                                <div class="d-block pb-2">
                                                    <div class="c">
                                                        <div onclick='{{ $credit["count_premium_advertising"] }} > 0 ? (location.href = "/"+"{{ app()->getLocale() }}"+"/advertising/create?type=premium&show_ad_type_option=true") : alert("{{ trans("have_no_package") }}")'
                                                            class="pe-auto bg-orange rounded-full ar-eq w-40px c d-inline-block mx-auto">
                                                            <i class="material-icons text-white">add</i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>{{ __('premium_ad') }}</p>
                                            </div>
                                        </div>
                                        <div class="w-100 px-2" style="height: 40px">
                                            <button type="submit" class=" mdc-button mdc-button--raised d-block"
                                                style="margin-left: auto">
                                                <span class="mdc-button__ripple"></span>
                                                <span class="mdc-button__label">{{__('buy')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="row">
                            @foreach($normals as $normal)
                            <div class="col-xs-12 col-sm-6 col-md-3 p-2">
                                <div class="mdc-card pricing-card text-center border-accent p-0 h-100">
                                    <div class="bg-accent pricing-header p-2">
                                        <h1 class="fs-sm-20"> @if( $normal->old_price > $normal->price ) <small> <span
                                                    class="del opacity-70">{{ $normal->old_price }} </span></small>
                                            @endif {{ $normal->price }}<small> {{__('kd_title')}}
                                                <br>
                                                {{-- {{ $normal->count_day }} {{__('days')}} --}}
                                            </small></h1>
                                        <p class="desc mb-2">
                                            @if(app()->getLocale()=="en"){{$normal->title_en}}@else{{$normal->title_ar}}@endif
                                        </p>
                                    </div>
                                    <div class="p-3">
                                        <p class="py-2">
                                            <!--<span class="mx-2 fw-500">10</span>-->
                                            @if(app()->getLocale()=="en"){{$normal->description_en}}@else{{$normal->description_ar}}@endif
                                        </p>

                                        <form method="post"
                                            action="{{ route('Main.buyPackageOrCredit',app()->getLocale()) }}">
                                            @csrf
                                            <input type="hidden" class="form-control" name="payment_type"
                                                value="CBKPay">
                                            <input type="hidden" name="type" value="normal">
                                            <input type="hidden" name="package_id" value="{{ $normal->id }}">
                                            <button type="submit" class="mdc-button mdc-button--raised">
                                                <span class="mdc-button__ripple"></span>
                                                <span class="mdc-button__label">{{__('buy')}}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
