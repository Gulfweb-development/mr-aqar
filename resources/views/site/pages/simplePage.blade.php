@extends('site.layout.master')
@section('title' , __('about_us_title'))
@section('content')

<main class="content-offset-to-top">
    <div class="px-3 mt-7">
        <div class="theme-container">
            <div class="mdc-card main-content-header mb-5 sec-min-h ">
                <div class="row">
                    <div class="col-12">
                        {!! app()->getLocale() == 'en' ? @$data_en : @$data_ar !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
