@extends('layouts.admin', ['crumbs' => [
    'Settings' => route('venueType')],
    'title' => __('venueTypes')
])
@section('content')
    <div class=" col-md-12">
        <div class="card">
            <div class="card-body">
            @component('components.venueType',['venueType'=>$venueType])@endcomponent
            </div>
        </div>
    </div>

@endsection
