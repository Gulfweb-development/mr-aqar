@extends('layouts.admin', ['crumbs' => [
    'Static Packages' => route('staticPackages.index')],
    'title' => __('Static Packages')
])
@section('content')
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{route('staticPackages.create')}}">
                            <i class="fa fa-fw fa-plus"></i>
                            {{__('Create New Package')}}
                        </a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-countries-tab" data-toggle="pill" href="#pills-countries" role="tab" aria-controls="pills-countries" aria-selected="true">{{__('Individual Static Packages')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-areas-tab" data-toggle="pill" href="#pills-areas" role="tab" aria-controls="pills-areas" aria-selected="false">{{__('Company Static Packages')}}</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-countries" role="tabpanel" aria-labelledby="pills-countries-tab">
                        @component('components.packages.staticList', ['type' =>"individual","packages"=>$packages])@endcomponent
                    </div>
                    <div class="tab-pane fade" id="pills-areas" role="tabpanel" aria-labelledby="pills-areas-tab">
                        @component('components.packages.staticList', ['type' =>"company","packages"=>$packages])@endcomponent
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

@endsection
