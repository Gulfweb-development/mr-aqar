@extends('layouts.admin', ['crumbs' => [
    'Balance History' => route('payments.index')],
    'title' => __('Balance History')
])
@section('css')
    <style>
        .not-pay{
            background-color: #ffa392!important;
        }
    </style>
@endsection
@section('content')
    <div class="card col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('List of Credit')}}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Count  Advertising </th>
                                    <th>Count Premium</th>
                                    <th>Count Usage</th>
                                    <th>Count Usage Premium</th>
                                    <th>Is Payed</th>
                                    <th>Date</th>
                                    <th>Expire Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="countries-list">
                                    @php $i=0; @endphp
                                    @foreach($list as $item)
                                        <tr @if($item->is_payed==0) class="not-pay" @endif>
                                            <td>{{++$i}}</td>
                                            <td>{{$item->title_en}}<br>{{$item->title_ar}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>{{$item->count}}</td>
                                            <td>{{$item->count_advertising}}</td>
                                            <td>{{$item->count_premium}}</td>
                                            <td>{{$item->count_usage}}</td>
                                            <td>{{$item->count_usage_premium}}</td>
                                            <td>{{$item->is_payed?"Yes":"No"}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->expire_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
