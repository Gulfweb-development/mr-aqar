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

    <form method="post" class="contact-form" action="{{ route('User.editUser',app()->getLocale()) }}"
          enctype="multipart/form-data">
        @csrf
        <div class="row">

                <div class="col-lg-6 col-md-6">
                    <div class="mdc-text-field mdc-text-field--outlined w-100">
                        <input type="text" name="name" id="name"
                               class="mdc-text-field__input @error('name') is-invalid @enderror"
                               placeholder="{{__('your_name')}}" value="{{ old('name' , auth()->user()->name)}}">
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label class="mdc-floating-label">{{__('full_name_title')}}</label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
                    </div>
                    @error('name')
                    <span class="invalid-feedback warn-color">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="text" disabled class="mdc-text-field__input" value="{{  auth()->user()->mobile}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('phone_number_title')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row mt-3">
                <div class="col-lg-6 col-md-6">
                    <div class="mdc-text-field mdc-text-field--outlined w-100">
                        <input type="email" name="email" id="email"
                               class="mdc-text-field__input @error('email') is-invalid @enderror"
                               placeholder="{{__('email_address_title')}}"
                               value="{{ old('email' , auth()->user()->email)}}">
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label class="mdc-floating-label">{{__('email_address_title')}}</label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback warn-color">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
        </div>

@if( auth()->user()->isCompany )
        <hr class="mt-3">
    <h3 class="my-2">{{__('company_settings')}}</h3>

        <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="text" name="company_name" id="company_name"
                           class="mdc-text-field__input @error('company_name') is-invalid @enderror"
                           placeholder="{{__('company_name_title')}}"
                           value="{{ old('company_name' , auth()->user()->company_name)}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('company_name_title')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('company_name')
                <span class="invalid-feedback warn-color">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="text" name="company_phone" id="company_phone"
                           class="mdc-text-field__input @error('company_phone') is-invalid @enderror"
                           placeholder="{{__('company_phone_title')}}"
                           value="{{ old('company_phone' , auth()->user()->company_phone)}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('company_phone_title')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('company_phone')
                <span class="invalid-feedback warn-color">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="email" name="social_email" id="social_email" placeholder="{{__('company_email')}}"
                           class="mdc-text-field__input @error('social_email') is-invalid @enderror"
                           value="{{ old('social_email' , optional(auth()->user()->socials()->where('type', 'email')->first())->address)}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('company_email')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('social_email')
                <span class="invalid-feedback warn-color">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="text" name="instagram" id="instagram"
                           class="mdc-text-field__input @error('instagram') is-invalid @enderror"
                           placeholder="{{__('instagram_address_title')}}"
                           value="{{ old('instagram' , optional(auth()->user()->socials()->where('type', 'instagram')->first())->address)}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('instagram_address_title')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('instagram')
                <span class="invalid-feedback warn-color">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field mdc-text-field--outlined w-100">
                    <input type="text" name="twitter" id="twitter"
                           class="mdc-text-field__input @error('twitter') is-invalid @enderror"
                           placeholder="{{__('twitter_address_title')}}"
                           value="{{ old('twitter' , optional(auth()->user()->socials()->where('type', 'twitter')->first())->address)}}">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label class="mdc-floating-label">{{__('twitter_address_title')}}</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
                @error('twitter')
                <span class="invalid-feedback warn-color">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>


        <hr class="mt-3">
@endif
        <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
{{--                <div class="mdc-text-field--outlined w-100">--}}
{{--                    <label class="text-muted w-100">{{__('get_verified_profile_title')}}</label>--}}
{{--                    <input type="file" name="licence" id="licence"--}}
{{--                           class="mdc-text-field__input @error('licence') is-invalid @enderror"--}}
{{--                           placeholder="{{__('get_verified_profile_title')}}">--}}
{{--                </div>--}}
                @error('licence')
                <span class="invalid-feedback warn-color">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mdc-text-field--outlined w-100">
                    <label class="text-muted w-100">{{__('profile_image_title')}}</label>
                    <input type="file" name="avatar" id="avatar"
                           class="mdc-text-field__input @error('avatar') is-invalid @enderror"
                           placeholder="{{__('profile_image_title')}}">
                </div>
                @error('avatar')
                <span class="invalid-feedback warn-color">
                                    <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>

        </div>

        <button type="submit" class="mdc-button mdc-button--raised mdc-ripple-upgraded"
                style="margin-top:30px;">{{__('save_title')}} &amp; {{__('upload_title')}}</button>
    </form>
@endsection
