@extends('site.layout.panel')
@section('title' , __('edit_profile_title'))
@section('panel-content')
@if((session('status')) == 'success')
<div class="alert alert-success">
	<strong>{{ __('success_title') }}!</strong> {{ __('profile_success') }}
</div>
@elseif((session('status')) == 'unsuccess')
<div class="alert alert-danger">
	<strong>{{ __('un_success_title') }}!</strong> {{ __('contact_unsuccess') }}
</div>
@endif

<form class="contact-form" action="/{{ app()->getLocale() }}/user/{{ auth()->user()->id }}" method="post" style="margin-top:30px;"
	onsubmit="confirm('{{ __('are_your_sure_you_want_to_delete_this_account') }}') ? this.submit() : event.preventDefault()">
	@csrf
	@method('DELETE')

	<h2>{{ __('delete_account_permanently') }}</h2>

	<div class="row mt-3">
		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="mdc-text-field mdc-text-field--outlined w-100">
				{{-- <label for="password" class="text-muted w-100">Current Password</label> --}}
				<input type="password" name="password" id="password"  required
					class="mdc-text-field__input @error('password') is-invalid @enderror"
					placeholder="{{__('Enter your password')}}">
				<div class="mdc-notched-outline">
					<div class="mdc-notched-outline__leading"></div>
					<div class="mdc-notched-outline__notch">
						<label class="mdc-floating-label">{{__('password')}}</label>
					</div>
					<div class="mdc-notched-outline__trailing"></div>
				</div>
			</div>
			@error('password')
			<span class="invalid-feedback warn-color">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>

	<hr class="mt-3">

	<button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100  bg-danger"
		style="margin-top:30px;">{{__('delete')}} {{__('account')}}</button>
	</form>
	<a href="{{  url()->previous() }}" class="mdc-button mdc-button--raised mdc-ripple-upgraded w-100"
		style="margin-top:30px;">{{__('go_back')}}</a>

@endsection
