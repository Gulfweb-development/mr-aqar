@extends('layouts.admin', ['crumbs' => [
    __('Payments') => route('payments.index'),
    __('Details') => route('payments.showDetail', $payment->id)]
, 'title' => __('View Payment Information')])
@section('css')
    <style>
        @media print{

            .vertical-menu-main { display: none; }
            .card-footer { display: none; }
            .page-header { display: none; }
            .page-main-header { display: none; }
            .main-header-left { display: none; }
            .main-header-right { display: none; }
            .logo-wrapper { display: none; }
            button {
                display: none;
            }
            img {
                display: none;
            }
            a{
                display: none;
            }
            i{
                display: none;
            }
            .sidebar-bar{
                display: none;
            }
            .media-body{
                display: none;
            }
            h6{
                display: none;
            }
        }
    </style>
    <style type="text/css" media="print">

    </style>
@endsection
@section('content')
    <div class="card col-md-12 mx-auto">
            <div class="card-body" id="DivIdToPrint">
                <div class="row">
                    <div class="col">
                        <h4>{{__('Payment Information')}}</h4>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Id')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $payment->id }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Ref Id')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->order)->api_ref_id??'----' }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Track Id')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->order)->trackid??'----' }}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Transaction Id')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->order)->tranid??'----' }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Payment Id')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->order)->payment_id??'----' }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Payment Type')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $payment->payment_type }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('User')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->user)->name??'----' }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Price')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $payment->price }} KD</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Status')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label @if($payment->status=='failed') text-danger @elseif($payment->status=='completed') text-success @else text-warning  @endif ">{{ $payment->status }}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Package')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($payment->package)->title_en }}</label>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label"> {{__('Date')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $payment->updated_at }}</label>
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Payment Id')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label text-info">{{ $payment->mobile }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Email')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label text-info">{{ $user->email }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Type')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label text-info">{{ $user->type_usage }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        @if($user->type_usage=="company")--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-sm-2 col-form-label"> {{__('Company Name')}}</label>--}}
{{--                                <div class="col-sm-3">--}}
{{--                                    <label class="col-form-label text-info">{{ $user->company_nam }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-sm-2 col-form-label"> {{__('Is Verified Company')}}</label>--}}
{{--                                <div class="col-sm-3">--}}
{{--                                    <label class="col-form-label  {{$user->verified_office==1?'text-success':'text-danger'}}">{{ $user->verified_office==1?"Yes":"No" }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}


{{--                        @endif--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Package')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label  text-info">{{ isset($user->package)?$user->package->title_en:"----" }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Count Advertising')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label  text-info">{{ $user->advertising()->count() }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-2 col-form-label"> {{__('Join Date')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                <label class="col-form-label text-info">{{ $user->created_at }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}


                    </div>
                </div>
            </div>
        <div class="card-footer">
            <a href="{{route('payments.index')}}" class="btn btn-light">{{__('Back To List')}}</a>
            <button id="print-window"  onclick='printDiv();'  class="btn btn-info">{{__('Print')}}</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function printDiv()
        {
            window.print();
            // var divToPrint=document.getElementById('DivIdToPrint');
            // var newWin=window.open('','Print-Window');
            // newWin.document.open();
            // newWin.document.write('<html>' +
            //     '' +
            //     '<body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            // newWin.document.close();
            // setTimeout(function(){newWin.close();},10);

        }


    </script>
@endsection