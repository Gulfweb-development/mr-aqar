<!DOCTYPE html>
<html lang="en" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!}>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }} @hasSection('title') - @yield('title') @endif </title>
	@yield('meta')
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/site.webmanifest">
	<link rel="shortcut icon" href="/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Scripts -->
	@include('site.layout.css')
	<script>
		window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
	</script>
	@yield('head')
</head>

<body class="mdc-theme--background" style="overflow-x: hidden">
	<div class="spinner-wrapper" id="preloader">
		<div class="spinner-container">
			<div class="spinner-outer">
				<div class="spinner">
					<img src="{{asset('images/main/loading.gif')}}" alt="loading" style="width: 100%;">
				</div>
				<p class="spinner-text">{{ __('PageTitle') }}</p>
			</div>
		</div>
	</div>
	{{-- can use: @extends('site.layout.master', ['header' => 'transparent']) for transparent(bg-image) header pages
	--}}
	@include('site.layout.header')

	@include('site.sections.fail-flash')

	@yield('content')

	@include('site.layout.footer')
	@include('site.layout.js')
	@yield('finalScripts')
</body>

</html>
