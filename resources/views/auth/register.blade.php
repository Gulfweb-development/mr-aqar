@extends('site.layout.master')
@section('title' , __('sign_up_title'))

@section('content')

    <main>
        <div class="px-3">
            <div class="theme-container">
                <div class="row center-xs middle-xs my-5">
                    <div class="mdc-card p-3 p-relative mw-500px">
                        <div class="column center-xs middle-xs text-center">
                            <h1 class="uppercase">{{__('sign_up_title')}}</h1>
                            <a href="{{ route('login',app()->getLocale()) }}" class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal w-100">
                                {{__('already_registered')}}
                                {{__('sign_in')}}
                            </a>
                        </div>
                        <form method="post" id="register-form" action="{{ route('register',app()->getLocale()) }}">
                            @csrf
                            @if ( old('codeValidation' , false ) )
                                <input type="hidden" name="type-usage" value="individual">
                                <input type="hidden" name="name" value="{{ old("name") }}">
                                <input type="hidden" name="mobile" value="{{ old("mobile") }}">
                                <input type="hidden" name="email" value="{{ old("email") }}">
                                <input type="hidden" name="password" value="{{ old("password") }}">
                                <input type="hidden" name="password_confirmation" value="{{ old("password_confirmation") }}">
                                <input type="hidden" name="codeValidation" value="{{ old("codeValidation") }}">
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field ">
                                    <i class="material-icons mdc-text-field__icon text-muted">terminal</i>
                                    <input id="code" type="number" placeholder="{{__('passcode')}}" class="mdc-text-field__input @error('code') is-invalid @enderror @if($errors->any()) is-invalid @endif" name="code" autofocus>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('passcode')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                                @error('code')
                                <span class="invalid-feedback warn-color d-inline-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <span class="invalid-feedback warn-color d-inline-block"><strong>{{$error}}</strong></span>
                                    @endforeach
                                @endif
                                <div id="resendcode"  onclick="submitForm();"   class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal w-100 mt-3" style="cursor: pointer;display: none;">
                                    <i class="material-icons mdc-text-field__icon text-muted">refresh</i>
                                    {{__('resend_code')}}
                                    <input type="checkbox" name="resend" id="resend" value="1" style="display: none;">
                                </div>

                                <div class="col-xs-12 w-100 py-3 text-center" style="min-width: 35vw;">
                                    <button class="mdc-button mdc-button--raised" type="submit">
                                        <span class="mdc-button__ripple"></span>
                                        <span class="mdc-button__label">{{__('sign_up_title')}}</span>
                                    </button>
                                </div>
                            @else
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field  @error('mobile') mdc-text-field--invalid @enderror">
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
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field  @error('password') mdc-text-field--invalid @enderror">
                                    <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                                    <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                                    <input  name="password" id="password" type="password" placeholder="{{__('password')}}" class="mdc-text-field__input" type="password" required>
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
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field @error('password') mdc-text-field--invalid @enderror">
                                    <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                                    <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                                    <input  name="password_confirmation" id="password_confirmation" type="password" placeholder="{{__('Confirm Password')}}" class="mdc-text-field__input" required>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('Confirm Password')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                <span class="invalid-feedback warn-color d-inline-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="text-center mt-2">
                                    <button class="mdc-button mdc-button--raised" type="submit">
                                        <span class="mdc-button__ripple"></span>
                                        <span class="mdc-button__label">{{__('sign_up_title')}}</span>
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection


@section('js')

    <script>
        function submitForm(){
            $( "#resend" ).attr("checked" , true);
            var form = document.createElement("form");
            var myForm = document.getElementById("register-form");
            form.submit.apply(myForm);
        }

        setTimeout(
            function() {
                $( "#resendcode" ).show();
            }, 10000);
    </script>
@endsection
