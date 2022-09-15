@extends('layouts.admin', ['crumbs' => [
    'Settings' => route('areas')],
    'title' => __('Areas')
])
@section('content')
    <div class=" col-md-12">
        <div class="card">
            @component('components.areas.areas', ['cities' => $cities, 'areas' => $areas])@endcomponent
        </div>

    </div>

@endsection
