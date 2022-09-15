@extends('layouts.admin', ['crumbs' => [
    __('Members') => route('members.index')]
,'title' => __('List of Members')])
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
{{--                    <div class="col-sm-4">--}}
{{--                        <a class="btn btn-primary" href="{{route('members.create')}}">--}}
{{--                            <i class="fa fa-fw fa-plus"></i>--}}
{{--                            {{__('Create New User')}}--}}
{{--                        </a>--}}
{{--                    </div>--}}

                    <div class="col-sm-3">
                        <input type="text" name="search_table" class="form-control  " id="search_table" placeholder="Search Name Or Mobile" value="{{request('search')}}" required="" autocomplete="off">

                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-success" onclick="search();">search</button>
                        <a type="button" class="btn btn-light" @if(request()->route()->getName()=="members.individual") href="{{route("members.individual")}}"  @elseif(request()->route()->getName()=="members.company") href="{{route("members.company")}}" @else href="{{route("members.index")}}" @endif >Cancel</a>
                    </div>

                </div>
            </div>


            <div class="card-body">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->getName()=="members.index") active @endif " href="{{route("members.index")}}" id="pills-countries-tab">{{__('All Users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->getName()=="members.individual") active @endif " href="{{route("members.individual")}}" id="pills-countries-tab">{{__('Individual Users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->getName()=="members.company") active @endif "  href="{{route("members.company")}}">{{__('Company Users')}}</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    @component('components.users.list', ['type' =>"individual","members"=>$members])@endcomponent

{{--                    <div class="tab-pane fade show active" id="pills-countries" role="tabpanel" aria-labelledby="pills-countries-tab">--}}
{{--                        @component('components.users.list', ['type' =>"individual","members"=>$members])@endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="tab-pane fade" id="pills-areas" role="tabpanel" aria-labelledby="pills-areas-tab">--}}
{{--                        @component('components.users.list', ['type' =>"company","members"=>$companyMembers])@endcomponent--}}
{{--                    </div>--}}
                </div>
            </div>

        </div>
    </div>
    @php
    if(request()->route()->getName()=="members.index"){
    $route ="/admin/members";
    }else if(request()->route()->getName()=="members.company"){
    $route ="/admin/members-company";
    }else if(request()->route()->getName()=="members.individual"){
    $route ="/admin/members-individual";
    }
    @endphp
    <script>
        function search() {
            var name=$("#search_table").val();
            var route="{{$route}}";
            window.location.href = route+"?search="+name;
        }


    </script>
@endsection
