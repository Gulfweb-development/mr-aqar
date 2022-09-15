@extends('site.layout.master')
@section('title' , __('paymentdetails'))

@section('content')

    <div class="container" style="margin:50px 0">
        <div class="row justify-content-center">
            <div class="mdc-card" style="padding: 15px; min-width: 50%;">
                <div class="card-body mdc-card__action--button">
                    <h4 class="card-title">{{optional($payment->package)->title_en}}</h4>

                    <p class="card-text">
                        {{__('price')}}: {{number_format( optional($payment)->price , 3 )}} {{__('kd_title')}}
                    </p>
                    <p class="card-text">
                        {{__('result')}}: <strong  @if($message=="CAPTURED")style="color:green;"  @else style="color:red;" @endif > {{$message}}</strong>
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
