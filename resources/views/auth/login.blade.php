@extends('site.layout.master')
@section('title' , __('login_title'))

@section('content')

    <main>
        <div class="px-3">
            <div class="theme-container">
                <div class="row center-xs middle-xs my-5">
                    <div class="mdc-card p-3 p-relative mw-500px">
                        <div class="column center-xs middle-xs text-center">
                            <h1 class="uppercase">{{__('welcome_back')}}</h1>
                            <a href="{{ route('register',app()->getLocale()) }}" class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal w-100">
                                {{__('new_to_site')}}
                                {{__('sign_up')}}
                            </a>
                        </div>
                        @if(session('status'))
                            <div class="alert alert-success">
                                <strong>{{ __('success_title') }}!</strong> {{session('status')}}!
                            </div>
                        @endif
                        <form method="post" action="{{ route('login',app()->getLocale()) }}">
                            @csrf
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field @error('password') mdc-text-field--invalid @enderror">
                                <i class="material-icons mdc-text-field__icon text-muted">phone</i>
                                <input id="mobile" type="tel" placeholder="{{__('phone_number_title')}}" class="mdc-text-field__input" name="mobile" value="{{ old('mobile') }}" required autofocus>
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">{{__('phone_number_title')}}</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                            @error('mobile')
                            <span class="invalid-feedback warn-color d-inline-block">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field @error('password') mdc-text-field--invalid @enderror">
                                <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                                <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                                <input  name="password" id="password" type="password" placeholder="{{__('password')}}" class="mdc-text-field__input" required autocomplete="current-password">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">{{__('password')}}</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback warn-color d-inline-block">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="mdc-form-field mt-3 w-100">
                                <div class="mdc-checkbox">
                                    <input type="checkbox" class="mdc-checkbox__native-control" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                    <div class="mdc-checkbox__ripple"></div>
                                </div>
                                <label for="keep" class="text-muted fw-500">{{ __('remember_me') }}</label>
                            </div>
                            <div class="text-center mt-2">
                                <button class="mdc-button mdc-button--raised" type="submit">
                                    <span class="mdc-button__ripple"></span>
                                    <span class="mdc-button__label">{{__('login')}}</span>
                                </button>
                            </div>
                        </form>
                        <div class="row my-4 px-3 p-relative">
                            <div class="divider w-100"></div>
                        </div>
                        <div class="row end-xs middle-xs">
                            <a href="{{ route('password.request',app()->getLocale()) }}" class="mdc-button normal">
                                <span class="mdc-button__ripple"></span>
                                <i class="material-icons mdc-button__icon">vpn_key</i>
                                <span class="mdc-button__label">{{__('forgot_password')}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
