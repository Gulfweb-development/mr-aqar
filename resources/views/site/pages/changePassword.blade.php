@extends('site.layout.panel')
@section('title' , __('change_password_title'))
@section('panel-content')
    @if((session('status')) == 'success')
        <div class="alert alert-success">
            <strong>{{ __('success_title') }}!</strong> {{ __('profile_success') }}
        </div>
    @elseif((session('status')) == 'unsuccess')
        <div class="alert alert-danger">
            <strong>{{ __('un_success_title') }}!</strong> {{ __('contact_unsuccess') }}
        </div>
    @elseif((session('status')) == 'dontmatch')
        <div class="alert alert-danger">
            <strong>{{ __('un_success_title') }}!</strong> {{ __('Passwords_not_match') }}
        </div>
    @endif

    <form method="post" class="contact-form" action="{{ route('User.changePassword', app()->getLocale()) }}">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="password" name="current" id="current"  class="mdc-text-field__input @error('current') is-invalid @enderror" placeholder="{{__('Current_Password')}}" required >
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('Current_Password')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('current')
                <span class="invalid-feedback warn-color">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="password" name="password" id="password"  class="mdc-text-field__input @error('password') is-invalid @enderror" placeholder="{{__('new_Password')}}" required  >
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('new_Password')}}</label>
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
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="password" name="password_confirmation" id="password_confirmation"  class="mdc-text-field__input @error('password_confirmation') is-invalid @enderror" placeholder="{{__('Confirm Password')}}" required  >
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('Confirm Password')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('password_confirmation')
                <span class="invalid-feedback warn-color">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

        </div>

        <button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded" style="margin-top:30px;">{{__('save_title')}} &amp; {{__('upload_title')}}</button>


    </form>
@endsection
{{--@section('pagination')--}}
{{--    dsadad--}}
{{--@endsection--}}
