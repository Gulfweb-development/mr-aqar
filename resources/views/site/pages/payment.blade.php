@extends('site.layout.master')
@section('title' , __('paymentdetails'))

@section('content')
<div class="container" style="margin:50px 0">
    <div class="row justify-content-center">
        <div class="mdc-card" style="padding: 15px; min-width: 50%;">
            <div class="card-body mdc-card__action--button">
                {{-- @if (@$payment) --}}
                {{-- <h4 class="card-title">
                    {{$payment->packageHistory->count >= 2 ? "{$payment->packageHistory->count} x " : '' }}
                    {{optional($payment->package)['title_' . app()->getLocale()]}}
                </h4>

                <p class="card-text">
                    @if(optional($payment)->packageHistory->count >= 2)
                    {{__('price')}}: {{number_format(optional($payment)->price , env('NUMFORMAT' , 0 ))}}
                    {{__('kd_title')}}
                    ({{optional($payment)->packageHistory->count}} x
                    {{number_format(optional($payment)->packageHistory->price , env('NUMFORMAT' , 0 ))}}
                    {{__('kd_title')}})
                    @else
                    {{__('price')}}: {{number_format(optional($payment)->price , env('NUMFORMAT' , 0 ))}}
                    {{__('kd_title')}}
                    @endif
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
                    {{__('ref')}}: {{$refId}}
                </p>
                --}}
                {{-- @elseif (@$paymentStatus) --}}

                @if (@$paymentStatus)
                <table class="table bordered">
                    <tbody>
                        <tr>
                            <td class="bg-muted">
                                <strong>{{ __('result') }}:</strong>&ensp;
                            </td>
                            <td>
                                <strong style="color:@if(@$unsuccessful || !@$payment) red @else green @endif;">
                                    {{@$paymentStatus->Message ?? @$message}}
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="bg-muted">
                                <strong>{{ __('date') }}:</strong>&ensp;
                            </td>
                            <td>
                                {{@$payment->created_at ? date('Y-m-d H:i:s', strtotime(@$payment->created_at)) : '' }}
                            </td>
                        </tr>


                        <tr>
                            <td class="bg-muted">
                                <strong>{{ __('transaction_id') }}:</strong>&ensp;
                            </td>
                            <td>
                                {{@$paymentStatus->TransactionId}}
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-muted">
                                <strong>{{ __('payment_id') }}:</strong>&ensp;
                            </td>
                            <td>
                                {{@$paymentStatus->PaymentId}}
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-muted">
                                <strong>{{ __("amount") }}:</strong>&ensp;
                            </td>
                            <td>
                                {{@$paymentStatus->Amount}} {{ __('kd_title') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                @php
                $static = auth()->user()->package;
                @endphp
                <div class="row ">
                    <div style="width: 50%">
                        <div class="mdc-card pricing-card text-center border-accent p-0 h-100">
                            <div class="bg-accent pricing-header px-2">
                                <p class="desc mb-2">
                                    @if(app()->getLocale()=="en"){{$static->title_en}}@else{{$static->title_ar}}@endif
                                </p>
                            </div>
                            <div class="px-2 ad-plan-bottom">
                                <div>
                                    <input type="hidden" class="form-control" name="payment_type" value="CBKPay">
                                    <div class="mdc-text-field mdc-text-field--outlined w-100 custom-field mb-1">
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div style="width: 50%">
                        <div class="c w-100 " style="height: calc(100% - 40px)">
                            <div class="text-center f-d-column">
                                <div class="d-block pb-2">
                                    <div class="c">
                                        <a href="/{{ app()->getLocale() }}/advertising/create?type=premium&show_ad_type_option=true"
                                            class="pe-auto text-decoration-none bg-orange rounded-full ar-eq w-40px c d-inline-block mx-auto">
                                            <i class="material-icons text-white">add</i>
                                        </a>
                                    </div>
                                </div>
                                <p>{{ __('premium_ad') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p class="card-text">
                    {{__('result')}}: <strong style="color: red;">
                        {{ __('sorry_something_went_wrong') }}
                    </strong>
                </p>

                @endif

            </div>
        </div>
    </div>
</div>
@endsection
