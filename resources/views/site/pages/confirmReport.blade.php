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
		<div class="theme-container">
			@if((session('status')) == 'success')
			<div class="alert alert-success">
				<strong>{{ __('success_title') }}!</strong> {{ __('profile_success') }}
			</div>
			@elseif((session('status')) == 'unsuccess')
			<div class="alert alert-danger">
				<strong>{{ __('un_success_title') }}!</strong> {{ __('contact_unsuccess') }}
			</div>
			@endif
			<style>
				input:where([type="checkbox"], [type="radio"]) {
					/* -webkit-appearance: none;
					appearance: none; */
					width: 22px;
					height: 22px;
					margin: calc(0.75em - 11px) 0.25rem 0 0;
					vertical-align: top;
					/* border: 2px solid #ddd; */
					border-radius: 4px;
					/* background: #fff no-repeat center center; */
				}

				/* input[type="radio"] {
					border-radius: 50%;
				} */

				/* input:where([type="checkbox"], [type="radio"]):where(:active:not(:disabled), :focus) {
					border-color: #696;
					outline: none;
				} */

				/* input:where([type="checkbox"], [type="radio"]):disabled {
					background: #eee;
				} */
				input[type="radio"]:checked,
				input[type="checkbox"]:checked {
					accent-color: var(--mdc-theme-primary)
				}
				.form-check{
					margin-block: 1rem; 
				}
			</style>
			<form class="contact-form" action="{{ $action }}" method="{{ @$method ?? 'post' }}"
				style="margin-top:30px;">
				@csrf

				<h2>{{ @$confirmMsg }}?</h2>
				
				<div class="form-check">
					<input type="radio" name="reason" id="offensive">
					<label for="offensive">{{ __('Offensive_content') }}</label>
				</div>
				<div class="form-check">
					<input type="radio" name="reason" id="fake">
					<label for="fake">{{ __('fake') .' '.( @$type == 'ad' ? __("advertising_title") : __('user')) }}</label>
				</div>
				<div class="form-check">
					<input type="radio" name="reason" id="suspicious">
					<label for="suspicious">{{ __('suspicious_or_spam') }}</label>
				</div>
				<div class="form-check">
					<input type="radio" name="reason" id="other">
					<label for="other">{{ __('other') }}</label>
				</div>
				<div class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea w-100">
					<textarea class="mdc-text-field__input" name="description" rows="5"
						placeholder="{{__('what_is_wrong')}}"></textarea>
					<div class="mdc-notched-outline mdc-notched-outline--upgraded">
						<div class="mdc-notched-outline__leading"></div>
						<div class="mdc-notched-outline__notch">
							<label
								class="mdc-floating-label">{{__('what_is_wrong')}}</label>
						</div>
						<div class="mdc-notched-outline__trailing"></div>
					</div>
				</div>
				<hr class="mt-3">

				<button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100  bg-danger"
					style="margin-top:30px;">{{__('confirm')}}</button>
			</form>
			<a href="{{  url()->previous() }}" class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100"
				style="margin-top:30px;">{{__('cancel')}}</a>
		</div>
	</div>
</main>
@endsection
