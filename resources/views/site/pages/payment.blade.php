@extends('site.layout.master')
@section('title' , __('paymentdetails'))

@section('content')

    <div class="container" style="margin:50px 0">
        <div class="row justify-content-center">
            <div class="mdc-card" style="padding: 15px; min-width: 50%;">
                <div class="card-body mdc-card__action--button">
                    <h4 class="card-title">{{$payment->packageHistory->count >= 2 ? "{$payment->packageHistory->count} x " : '' }}{{optional($payment->package)['title_' . app()->getLocale()]}}</h4>

                    <p class="card-text">
                        @if(optional($payment)->packageHistory->count >= 2)
                            {{__('price')}}: {{number_format(optional($payment)->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}
                            ({{optional($payment)->packageHistory->count}} x {{number_format(optional($payment)->packageHistory->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}})
                        @else
                            {{__('price')}}: {{number_format(optional($payment)->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}
                        @endif
                    </p>
                    <p class="card-text">
                        {{__('result')}}: <strong  @if($message=="CAPTURED")style="color:green;"  @else style="color:red;" @endif > {{$message}}</strong>
                    </p>
                    <p class="card-text">
                        {{__('number_of_normal_ads')}}: {{optional($payment)->packageHistory->count_advertising}}
                    </p>
                    <p class="card-text">
                        {{__('number_of_premium_ads')}}: {{optional($payment)->packageHistory->count_premium}}
                    </p>
                    <h4 class="card-title">{{ __('paymentdetails') }}</h4>
                    <p class="card-text">
                        {{__('date')}}: {{optional($payment)->updated_at}}
                    </p>
                    <p class="card-text">
                        {{__('paymentid')}}: {{optional($order)->payment_id}}
                    </p>
                    <p class="card-text">
                        {{__('tranid')}}: {{optional($order)->tranid}}
                    </p>
                    <p class="card-text">
                        {{__('trackid')}}: {{optional($order)->trackid}}
                    </p>
{{--                    <p class="card-text">--}}
{{--                        Auth ID: {{optional($order)->auth}}--}}
{{--                    </p>--}}
                    <p class="card-text">
                        {{__('ref')}}: {{$refId}}
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection
