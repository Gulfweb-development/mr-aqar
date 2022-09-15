@extends('layouts.admin', ['crumbs' => [
    'Settings' => route('cities')],
    'title' => __('Cities')
])
@section('content')
    <div class="col-md-12">
        <div class="card">
            @component('components.areas.cities', ['cities' => $cities]) @endcomponent
        </div>
    </div>

@endsection
