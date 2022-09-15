@extends('layouts.admin', ['crumbs' => [
    'Advertising' => route('advertising.index')],
    'title' => $type." ".__('Advertising')
])
@section('css')
    <style>
        .expire{
            background-color: #ffa392!important;
        }
        .premium{
            background-color: #c1ceff!important;
        }
        .select2 {
            display: block;
            width: 90%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

    </style>
@endsection
@section('content')
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="get" action="{{ request()->route()->getName() == "advertising.index" ? route('advertising.index') : route('advertising.indexCompanies')}}">
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="fromDate" class=" col-form-label">{{__('Min Price')}}</label>
                                            <input type="text" @if(isset(request()->min_price)) value="{{request()->min_price}}"  @endif class="form-control" name="min_price" placeholder="Type {{__('Min Price')}}..." >

                                        </div>
                                        <div class="col-md-6">
                                            <label for="fromDate" class=" col-form-label">{{__('Max Price')}}</label>
                                            <input type="text" class="form-control" @if(isset(request()->max_price)) value="{{request()->max_price}}"  @endif id="max_price" name="max_price" placeholder="Type {{__('Max Price')}}..." >

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">

                                        <div class="col-sm-4">
                                            <label for="fromDate" class=" col-form-label">{{__('Start Date')}}</label>
                                            <input type="date" @if(isset(request()->fromDate)) value="{{request()->fromDate}}"  @endif  name="fromDate" id="from-date" class="form-control" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="fromDate" class=" col-form-label">{{__('Start Date')}}</label>
                                            <input type="date" @if(isset(request()->toDate)) value="{{request()->toDate}}" @endif placeholder="{{__('End Date')}}" name="toDate" id="to-date" class="form-control" />
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="form-group row">

                                <div class="col-lg-3">
                                        <input type="text" @if(isset(request()->hash_number)) value="{{request()->hash_number}}"  @endif class="form-control" name="hash_number" placeholder="{{__('Hash number')}}..." >
                                </div>

                                <div class="col-lg-3">
                                    <select name="area_id"  id="area" class="form-control">
                                        <option value="" selected disabled>{{__('Select an area')}}</option>
                                        <option value="all">all</option>
                                        @foreach($area as $area)
                                            <option value="{{$area->id}}" @if(Request()->area_id==$area->id) selected @endif>{{$area->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--
{{--                                <div class="col-sm-2">--}}
{{--                                    <label for="fromDate"  class=" col-form-label">{{__('City')}}</label>--}}
{{--                                    <select name="city_id" style="width:100%" id="city" class="form-control">--}}
{{--                                        <option value="all">all</option>--}}
{{--                                        @foreach($city as $item)--}}
{{--                                            <option value="{{$item->id}}">{{$item->name_en}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                  -->


                                <div class="col-lg-3">
                                    <select id="user"  name="user_id" class="form-control">
                                        <option value="" selected disabled>{{__('Select an user')}}</option>
                                        <option value="all">all</option>
                                        @if(!empty($users) && count($users)>0)
                                        @foreach($users as $user)
                                        <option value="{{$user->uid}}" @if(Request()->user_id==$user->uid) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!--
                                {{--                                <div class="col-sm-2">--}}
                                {{--                                    <label for="fromDate" class=" col-form-label">{{__('User Type')}}</label>--}}
                                {{--                                    <select   name="user_type" class="form-control">--}}
                                {{--                                        <option @if(isset(request()->user_type) && request()->user_type=="all" ) selected  @endif value="all">all</option>--}}
                                {{--                                        <option @if(isset(request()->user_type) && request()->user_type=="company" )  selected  @endif value="company">company</option>--}}
                                {{--                                        <option @if(isset(request()->user_type) && request()->user_type=="individual")  selected  @endif value="individual">individual</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                                -->

                                <div class="col-lg-3">
                                    <button type="submit"  class="btn btn-secondary"><i class="fa fa-fw fa-search"></i> {{__('Filter')}}</button>
                                    <button type="button" class="btn btn-light" onclick="window.location.href='{{$type=="individual"?"/admin/advertising-list/individual":"/admin/advertising-list/companies"}}'"><i class="fa fa-fw fa-close"></i> {{__('Cancel')}}</button>

                                </div>
                            </div>
                            @if(request()->page!=null && request()->all()>=2)
                                <input type="hidden" name="page" value="{{request()->page}}">
                            @endif
                        </form>
                    </div>

                </div>
            </div>
            <div class="card-body">
                @component('components.advertising.list', ['type' =>"individual","advertising"=>$advertising])@endcomponent
            </div>
            <div class="modal" id="edit_modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{__('Advertising Details')}}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <div class= "form-group row content-loader">
                                @include('components.loader')
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label for="fromDate" class=" col-form-label">{{__('Title')}}</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="area"  placeholder="title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label for="fromDate" class=" col-form-label">{{__('Title Ar')}}</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="area"  placeholder="title ar">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label for="fromDate" class=" col-form-label">{{__('Price')}}</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="area"  placeholder="Price">
                                </div>
                            </div>




                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function destroy(itemId) {
            swal({
                title: "{{__('Are you sure you want to delete this item?')}}",
                text: "{{__('Be aware that deletion process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('destroy-form-'+itemId).submit();
                }
            });
        }

        function accept(id) {
            swal({
                title: "{{__('Are you sure you want to accept item?')}}",
                text: "{{__('Be aware that deletion process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Accept')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('accept-form-'+id).submit();
                }
            });
        }
        $(function () {

            $("#area").select2();
            $("#city").select2();
            $("#user").select2();

        });
    </script>
@endsection

