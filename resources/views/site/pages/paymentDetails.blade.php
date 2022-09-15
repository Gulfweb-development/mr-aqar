@extends('site.layout.panel')
@section('title' , __('paymentdetails'))


@section('panel-content')

    <div id="result" ></div>
    @php
        $dir = app()->getLocale()=="en"?"ltr":"rtl";
        $align = app()->getLocale()=="en"?"left":"right";
        $aligno = app()->getLocale()=="en"?"right":"left";
    @endphp
    @if((session('status')) == 'package_bought')
        <div class="alert alert-success">
            <strong>{{ __('success_title') }}!</strong> {{ __('packageSuccess') }} !
        </div>
    @endif

    @if(!empty($paymentsDetails->id))
{{--        <h5>{{__('paymentdetails')}}</h5>--}}
            <!--box start -->
            @if($paymentsDetails->trackid)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('trackid')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->trackid}}</div>
                </div>
            @endif
            @if($paymentsDetails->payment_id)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('paymentid')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->payment_id}}</div>
                </div>
            @endif


            @if(!empty($paymentsDetails->ref))
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('ref')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->ref}}</div>
                </div>
            @endif
            @if($paymentsDetails->tranid)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('tranid')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->tranid}}</div>
                </div>
            @endif
            @if($paymentsDetails->presult)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('result')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->presult}}</div>
                </div>
            @endif
            @if($paymentsDetails->amt)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('amount')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->amt}} {{__('kd_title')}}</div>
                </div>
            @endif

            @if($paymentsDetails->created_at)
                <div class="row mt-2">
                    <strong class="col-lg-4 col-md-4 col-sm-12">{{__('date')}}</strong>
                    <div class="col-lg-8 col-md-8 col-sm-12">{{$paymentsDetails->created_at}}</div>
                </div>
            @endif
        <!--box end -->
    @else
        <div class="alert alert-warning text-center">{{__('norecord')}}</div>
    @endif
    <div style="clear:both;"></div>

@endsection
