@extends('site.layout.panel')
@section('title' , __('package_history_title'))

@php
    $float = app()->getLocale()=="en"?"right":"left";
@endphp

@section('panel-content')

@if((session('status')) == 'package_bought')
    <div class="alert alert-success">
        <strong>{{ __('success_title') }}!</strong> {{ __('packageSuccess') }} !
    </div>
@endif
<div class="mdc-data-table border-0 w-100 mt-3">
    <table class="mdc-data-table__table" aria-label="Dessert calories">
        <thead>
            <tr class="mdc-data-table__header-row">
                <th class="mdc-data-table__header-cell">{{__('row_title')}}</th>
                <th class="mdc-data-table__header-cell">{{__('package_title')}}</th>
                {{--            <th class="mdc-data-table__header-cell">{{__('noofads')}}</th>--}}
                <th class="mdc-data-table__header-cell">{{__('price_title')}}({{__('kd_title')}})</th>
                <th class="mdc-data-table__header-cell">{{__('date_title')}}</th>
                <th class="mdc-data-table__header-cell">{{__('details')}}</th>
                <th class="mdc-data-table__header-cell">{{__('status')}}</th>
            </tr>
        </thead>
        <tbody class="mdc-data-table__content">
            <?php $i = ($payments->currentpage() - 1) * $payments->perpage() + 1;?>
            @foreach($payments as $payment)
                <tr class="mdc-data-table__row">
                    <td class="mdc-data-table__cell">{{$i++}}</td>
                    <td class="mdc-data-table__cell">{{ app()->getLocale()==='en'?$payment->title_en:$payment->title_ar }} @if( $payment->count > 1 )
                            (x {{ $payment->count }})
                        @endif</td>
                    {{--                <td class="mdc-data-table__cell">{{ $payment->count }}</td>--}}
                    <td class="mdc-data-table__cell">{{!empty($payment->price)? number_format($payment->price * $payment->count , env('NUMFORMAT' , 0 )) : number_format(0 , env('NUMFORMAT' , 0 ))}}</td>
                    <td class="mdc-data-table__cell">{{ $payment->date }}</td>
                    <td class="mdc-data-table__cell" style="min-width: 240px;">
                        <div>{{__('remain_regular_ads')}}:<a href="javascript:;"
                                                             style="float: {{ $float }}; text-decoration: none; color: var(--theme-base-color);">{{($payment->is_payed == 1)?($payment->count_advertising - $payment->count_usage):0}}
                                / {{$payment->count_advertising * $payment->count  }}</a></div>
                        <div>{{__('remain_premium_ads')}}:<a href="javascript:;"
                                                             style="float: {{ $float }}; text-decoration: none; color: var(--theme-base-color);">{{($payment->is_payed == 1)?($payment->count_premium - $payment->count_usage_premium):0}}
                                / {{$payment->count_premium * $payment->count  }} </a></div>
                    </td>
                    <td class="mdc-data-table__cell">
                        @if($payment->price == 0)
                            <span class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal">
                            {{__('free')}}
                        </span>
                        @else
                            <a href="{{url(app()->getLocale().'/paymentdetails/'.$payment->payment_id)}}"
                               class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal">
                                @if($payment->is_payed==1)
                                    {{__('details')}}(<span class="text-success">{{__('paid_title')}}</span>)
                                @else
                                    {{__('details')}}(<span class="text-danger">{{__('not_paid_title')}}</span>)
                                @endif
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('pagination')
    {{ $payments->links('vendor.pagination.housekey') }}
@endsection
