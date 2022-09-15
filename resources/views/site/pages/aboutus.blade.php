@extends('site.layout.master')
@section('title' , __('about_us_title'))
@section('content')

<main class="content-offset-to-top">
{{--    <div class="header-image-wrapper">--}}
{{--        <div class="bg" style="background-image: url('{{ url('') }}/asset/images/others/about.jpg');"></div>--}}
{{--        <div class="mask"></div>--}}
{{--        <div class="header-image-content offset-bottom">--}}
{{--            <h1 class="title">{{ __('about_us_title') }}</h1>--}}
                    {{--            <p class="desc">We help you for find your house key</p>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="section default mt-0">
        <div class="px-3">
            <div class="theme-container">
                <h1 class="section-title">{{ __('about_us_title') }}</h1>
                <div class="mdc-card p-0 row o-hidden">
{{--                    <div class="col-xs-12 col-lg-6 col-xl-6 p-3">--}}
                    <div class="col-xs-12 col-lg-12 col-xl-12 px-3 py-4">
                        <div class="row d-block">
                            @if(app()->getLocale()=="en"){!!!empty($aboutus_large_en)?$aboutus_large_en:''!!}@else{!!!empty($aboutus_large_ar)?$aboutus_large_ar:''!!}@endif
                        </div>
                    </div>
{{--                    <div class="col-xs-12 col-lg-6 col-xl-6 p-0 d-none d-lg-flex d-xl-flex aboutus_large_pic1">--}}
{{--                        @if($aboutus_large_pic1){!!$aboutus_large_pic1!!}@endif--}}
{{--                    </div>--}}
                </div>

            </div>
        </div>
    </div>
    <div class="section mt-3">
        <div class="px-3">
            <div class="theme-container">
{{--                <h1 class="section-title">Our Services</h1>--}}
                <div class="services-wrapper row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 p-2">
                        <div class="mdc-card h-100 w-100 text-center middle-xs p-3">
                            <i class="material-icons mat-icon-xlg primary-color">history_edu</i>
                            <h2 class="capitalize fw-600 my-3">{{__('ourstory')}}</h2>
{{--                            <p class="text-muted fw-500">When you make it easy to do business, your business grows.</p>--}}
                            <div class="row">
                                <div class="text-muted fw-500">
                                    @if(app()->getLocale()=="en")
                                        {!!!empty($our_story_en)?$our_story_en:''!!}@else{!!!empty($our_story_ar)?$our_story_ar:''!!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 p-2">
                        <div class="mdc-card h-100 w-100 text-center middle-xs p-3">
                            <i class="material-icons mat-icon-xlg primary-color">format_list_bulleted</i>
                            <h2 class="capitalize fw-600 my-3">{{__('ourvalues')}}</h2>
                            <div class="row">
                                <div class="text-muted fw-500">
                                    @if(app()->getLocale()=="en"){!!!empty($our_value_en)?$our_value_en:''!!}@else{!!!empty($our_value_ar)?$our_value_ar:''!!}@endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 p-2">
                        <div class="mdc-card h-100 w-100 text-center middle-xs p-3">
                            <i class="material-icons mat-icon-xlg primary-color">handshake</i>
                            <h2 class="capitalize fw-600 my-3">{{__('ourpromise')}}</h2>
                            <div class="row">
                                <div class="text-muted fw-500">
                                    @if(app()->getLocale()=="en"){!!!empty($our_promise_en)?$our_promise_en:''!!}@else{!!!empty($our_promise_ar)?$our_promise_ar:''!!}@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
