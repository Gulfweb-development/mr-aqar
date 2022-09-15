@extends('site.layout.master')
@section('title' , __('forgot_password'))

@section('content')

    <main>
        <div class="px-3">
            <div class="theme-container">
                <div class="row center-xs middle-xs my-5">
                    <div class="mdc-card p-3 p-relative mw-500px">
                        <div class="column center-xs middle-xs text-center">
                            <h1 class="uppercase">{{__('forgot_password')}}</h1>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                    <div>{{$error}}</div>
                            @endforeach
                            </div>
                        @endif
                        <form method="post"  id="forgot-form" action="{{ route('password.email',app()->getLocale()) }}">
                            @csrf
                            @if ( old('codeValidation' , false ) )
                                <input type="hidden" name="mobile" value="{{ old("mobile") }}">
                                <input type="hidden" name="codeValidation" value="{{ old("codeValidation") }}">
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field ">
                                    <i class="material-icons mdc-text-field__icon text-muted">terminal</i>
                                    <input id="code" type="number" placeholder="{{__('passcode')}}" class="mdc-text-field__input @error('code') is-invalid @enderror @if($errors->any()) is-invalid @endif" name="code" value="" autofocus>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('passcode')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                                <div id="resendcode"  onclick="submitForm();"   class="mdc-button mdc-ripple-surface mdc-ripple-surface--primary normal w-100 mt-3" style="cursor: pointer;display: none;">
                                    <i class="material-icons mdc-text-field__icon text-muted">refresh</i>
                                    {{__('resend_code')}}
                                    <input type="checkbox" name="resend" id="resend" value="1" style="display: none;">
                                </div>
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field">
                                    <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                                    <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                                    <input  name="password" id="password" type="password" placeholder="{{__('password')}}" class="mdc-text-field__input @error('password') is-invalid @enderror" type="password" required>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('password')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field">
                                    <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                                    <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                                    <input  name="password_confirmation" id="password_confirmation" type="password" placeholder="{{__('Confirm Password')}}" class="mdc-text-field__input @error('password') is-invalid @enderror" required>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('Confirm Password')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>

                                <div class="text-center mt-2">
                                    <button class="mdc-button mdc-button--raised" type="submit">
                                        <span class="mdc-button__ripple"></span>
                                        <span class="mdc-button__label">{{__('Reset Password')}}</span>
                                    </button>
                                </div>
                            @else
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field ">
                                    <i class="material-icons mdc-text-field__icon text-muted">phone</i>
                                    <input id="mobile" type="tel" placeholder="{{__('phone_number_title')}}" class="mdc-text-field__input @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autofocus>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label class="mdc-floating-label">{{__('phone_number_title')}}</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <button class="mdc-button mdc-button--raised" type="submit">
                                        <span class="mdc-button__ripple"></span>
                                        <span class="mdc-button__label">{{__('Reset Password')}}</span>
                                    </button>
                                </div>
                            @endif
                        </form>
                        <div class="row my-4 px-3 p-relative">
                            <div class="divider w-100"></div>
                        </div>
                        <div class="row end-xs middle-xs">
                            <a href="{{  route('login',app()->getLocale()) }}" class="mdc-button normal">
                                <span class="mdc-button__ripple"></span>
                                <i class="material-icons mdc-button__icon">vpn_key</i>
                                <span class="mdc-button__label">{{__('login_title')}}</span>
                            </a>
                        </div>
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
            var myForm = document.getElementById("forgot-form");
            form.submit.apply(myForm);
        }

        setTimeout(
            function() {
                $( "#resendcode" ).show();
            }, 10000);
    </script>
@endsection
