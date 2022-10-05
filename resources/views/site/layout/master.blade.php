@php
$desc = @app()->view->getSections()['meta_description'] ? strip_tags(app()->view->getSections()['meta_description']) :
\App\Http\Controllers\site\MessageController::getSettingDetails('meta_description_' . app()->getLocale());
$keywords = @app()->view->getSections()['meta_keywords'] ? strip_tags(app()->view->getSections()['meta_keywords']) :
\App\Http\Controllers\site\MessageController::getSettingDetails('keywords_' . app()->getLocale());
@endphp

<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" {!! app()->getLocale() === 'ar' ? ' dir="rtl"' : '' !!}>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@hasSection('title')@yield('title') | @endif{{ $title }}</title>


	@hasSection('meta')
	@yield('meta_description')
	@else
	<meta name="description" content="{{$desc}}">
	<meta name="keywords" content="{{$keywords}}">
	@endif

	<link rel="canonical" href=”https://mr-aqar.com” />

	<meta property="og:site_name" content="{{ config('app.name') }}">
	<meta property="og:locale" content="{{ app()->getLocale() }}_GB" />
	<meta property="og:title" content="@hasSection('title')@yield('title') | @endif{{ $title }}" />
	<meta property="og:description" content="{{$desc}}" />
	<meta property="og:image" itemprop="image"
		content="{{ asset('images/main/logo_header_' . app()->getLocale() . '.jpg') }}">
	<meta property="og:type" content="website" />

	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/site.webmanifest">
	<link rel="shortcut icon" href="/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<meta name=”robots” content=”noindex, follow” />
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

	<div class="modal" id="confirm-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{ __('confirmation') }}</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					
					<button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded yes">
						<span class="mdc-button__ripple">
						</span>
						<span class="mdc-button__label">
							{{ __('yes_title') }}
						</span>
					</button>
					<button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded bg-danger" data-dismiss="modal">
						<span class="mdc-button__ripple">
						</span>
						<span class="mdc-button__label">
							{{ __('no_title') }}
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>

	@include('site.layout.js')


	<script>
		function confirmModal(event,title, callback){
			event.stopPropagation();
            $('#confirm-modal .modal-body').html(`<h2>${title}</h2>`)
            $('#confirm-modal .yes').on('click', callback);
            $('#confirm-modal').css('display', 'flex');
        }
		$('[data-dismiss="modal"]').on('click', function() {
			$(this).closest('.modal').hide();
		})
		$('[data-bs-toggle="modal"]').on('click', function() {			
			let id = $(this).data('target') || $(this).data('bs-target');
			$(id).css('display', 'flex');
		})
	</script>

	@yield('finalScripts')
</body>

</html>
