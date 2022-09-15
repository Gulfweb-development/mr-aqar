@extends('layouts.admin', ['crumbs' => [
    'Packages' => route('packages.index')],
    'title' => __('Packages')
])
@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{route('packages.create')}}">
                            <i class="fa fa-fw fa-plus"></i>
                            {{__('Create New Package')}}
                        </a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->getName()=="packages.individual.index" || request()->route()->getName()=="packages.index" ) active @endif" id="pills-countries-tab"  href="{{route("packages.individual.index")}}"  >{{__('Individual Packages')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->route()->getName()=="packages.company.index") active @endif" id="pills-areas-tab"  href="{{route("packages.company.index")}}"  >{{__('Company Packages')}}</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="pills-tabContent">

                    @component('components.packages.list', ["packages"=>$packages])@endcomponent

                    {{--                    <div class="tab-pane fade show active" id="pills-countries" role="tabpanel" aria-labelledby="pills-countries-tab">--}}
{{--                        @component('components.packages.list', ['type' =>"individual","packages"=>$packages])@endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="tab-pane fade" id="pills-areas" role="tabpanel" aria-labelledby="pills-areas-tab">--}}
{{--                        @component('components.packages.list', ['type' =>"company","packages"=>$packages])@endcomponent--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>



    </div>
@endsection

@section('scripts')

@endsection
