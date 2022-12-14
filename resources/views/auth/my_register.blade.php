@extends('site.layout.master')

@section('content')

<main>
    <div class="px-3">
        <div class="theme-container">
            <div class="row center-xs middle-xs my-5">
                <div class="mdc-card p-3 p-relative mw-500px">
                    <div class="column center-xs middle-xs text-center">
                        <h1 class="uppercase">Register</h1>
                        <a href="login.html" class="mdc-button mdc-ripple-surface mdc-ripple-surface--accent accent-color normal w-100">
                            Already have an account? Sign in!
                        </a>
                    </div>
                    <form action="javascript:void(0);">
                        <div class="mdc-select mdc-select--outlined mdc-select--with-leading-icon mt-3 custom-field">
                            <div class="mdc-select__anchor w-100">
                                <i class="material-icons mdc-select__icon pt-1">group</i>
                                <i class="mdc-select__dropdown-icon"></i>
                                <div class="mdc-select__selected-text"></div>
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">User Type</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                            <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                <ul class="mdc-list">
                                    <li class="mdc-list-item mdc-list-item--selected" data-value=""></li>
                                    <li class="mdc-list-item" data-value="1">Agent</li>
                                    <li class="mdc-list-item" data-value="2">Agency</li>
                                    <li class="mdc-list-item" data-value="3">Buyer</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field ">
                            <i class="material-icons mdc-text-field__icon text-muted">person</i>
                            <input class="mdc-text-field__input">
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label class="mdc-floating-label">Username</label>
                                </div>
                                <div class="mdc-notched-outline__trailing"></div>
                            </div>
                        </div>
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon w-100 mt-3 custom-field ">
                            <i class="material-icons mdc-text-field__icon text-muted">email</i>
                            <input class="mdc-text-field__input">
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label class="mdc-floating-label">Email</label>
                                </div>
                                <div class="mdc-notched-outline__trailing"></div>
                            </div>
                        </div>
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field">
                            <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                            <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                            <input class="mdc-text-field__input" type="password">
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label class="mdc-floating-label">Password</label>
                                </div>
                                <div class="mdc-notched-outline__trailing"></div>
                            </div>
                        </div>
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon w-100 custom-field mt-4 custom-field">
                            <i class="material-icons mdc-text-field__icon text-muted">lock</i>
                            <i class="material-icons mdc-text-field__icon text-muted password-toggle" tabindex="1">visibility_off</i>
                            <input class="mdc-text-field__input" type="password">
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label class="mdc-floating-label">Confirm Password</label>
                                </div>
                                <div class="mdc-notched-outline__trailing"></div>
                            </div>
                        </div>
                        <div class="mdc-form-field mt-3 w-100">
                            <div class="mdc-checkbox">
                                <input type="checkbox" class="mdc-checkbox__native-control" id="keep"/>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                                <div class="mdc-checkbox__ripple"></div>
                            </div>
                            <label for="keep" class="text-muted fw-500">Receive Newsletter</label>
                        </div>
                        <div class="text-center mt-2">
                            <button class="mdc-button mdc-button--raised bg-accent" type="submit">
                                <span class="mdc-button__ripple"></span>
                                <span class="mdc-button__label">Create an Account</span>
                            </button>
                        </div>
                    </form>
                    <div class="row my-4 px-3 p-relative">
                        <div class="divider w-100"></div>
                    </div>
                    <div class="row center-xs middle-xs">
                        <small>By clicking the "Create an Account" button you agree with our</small>
                        <a href="terms.html" class="mdc-button normal">
                            <span class="mdc-button__ripple"></span>
                            <span class="mdc-button__label">Terms and conditions</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
