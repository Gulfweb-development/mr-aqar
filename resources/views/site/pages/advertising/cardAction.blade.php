@extends('site.layout.master')
@section('title' , __('report'))
@section('content')

<main class="content-offset-to-top">
	{{-- <div class="header-image-wrapper">--}}
		{{-- <div class="bg" style="background-image: url('{{ url('') }}/asset/images/others/about.jpg');"></div>--}}
		{{-- <div class="mask"></div>--}}
		{{-- <div class="header-image-content offset-bottom">--}}
			{{-- <h1 class="title">{{ __('about_us_title') }}</h1>--}}
			{{-- <p class="desc">We help you for find your house key</p>--}}
			{{-- </div>--}}
		{{-- </div>--}}
	<div class="px-3 mt-7">
		<h2 class="text-center">{{ __("ad_actions") }}</h2>
		<div class="theme-container" style="min-height: calc(100vh - 400px)">
			<a href="/{{ app()->getLocale() }}/confirm-report/ad/{{ $ad->id }}"
				class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100" style="margin-top:30px;"><i class="material-icons-outlined text-sm 
				text-white mb-1" style="font-size: 22px">sms_failed</i>&ensp;{{__('report')}}</a>
			<a href="/{{ app()->getLocale() }}/confirm-block/ad/{{ $ad->id }}"
				class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100"
				style="margin-top:30px;"> <i class="material-icons-outlined text-sm text-white  mb-1"
				style="font-size: 22px">block</i>&ensp;{{__('block')}}</a>
		</div>
	</div>
</main>
@endsection
