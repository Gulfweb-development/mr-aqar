@extends('site.layout.master')
@section('title' , __('company_form'))

@section('content')

    <main>
        <div class="px-3">
            <div class="theme-container">
                <div class="mdc-card mt-5 p-5">
                    <form method="post" action="{{ route('companies.store', app()->getLocale()) }}" class="contact-form"
                          enctype="multipart/form-data">
                        <div class="row agent-wrapper">
                            @csrf
                            <div class="col-xs-12 col-sm-8 col-md-9 p-3">
                                <h3 class="">{{__('company_form')}}</h3>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="mdc-text-field mdc-text-field--outlined w-100 mt-3">
                                            <input name="company_name" value="{{ old('company_name') }}" placeholder="{{__('company_name_title')}}" id="company_name" class="mdc-text-field__input" required>
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="company_name" class="mdc-floating-label">{{__('company_name_title')}}</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('company_name')
                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="mdc-text-field mdc-text-field--outlined w-100 mt-3">
                                            <input name="company_phone" value="{{ old('company_phone') }}" placeholder="{{__('company_phone_title')}}" id="company_phone" class="mdc-text-field__input" required>
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="company_phone" class="mdc-floating-label">{{__('company_phone_title')}}</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('company_phone')
                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="mdc-text-field mdc-text-field--outlined w-100 mt-3">
                                            <input name="email" value="{{ old('email') }}" placeholder="{{__('company_email')}}" id="email" class="mdc-text-field__input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="email" class="mdc-floating-label">{{__('company_email')}}</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="mdc-text-field mdc-text-field--outlined w-100 mt-3">
                                            <input name="instagram" value="{{ old('instagram') }}" placeholder="{{__('instagram_address_title')}}" id="instagram" class="mdc-text-field__input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="instagram" class="mdc-floating-label">{{__('instagram_address_title')}}</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('instagram')
                                        <span class="invalid-feedback warn-color d-inline-block">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="mdc-text-field mdc-text-field--outlined w-100 mt-3">
                                            <input name="twitter" value="{{ old('twitter') }}" placeholder="{{__('twitter_address_title')}}" id="twitter" class="mdc-text-field__input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="twitter" class="mdc-floating-label">{{__('twitter_address_title')}}</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('twitter')
                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="w-100 text-center mt-4">
                                    <button type="submit" class="mdc-button mdc-button--raised">
                                        <span class="mdc-button__ripple"></span>
                                        <span class="mdc-button__label">{{__('register_company')}}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3 p-3 center-xs">
                                <img src="{{ asset('/asset/images/logo-placeholder-image.png') }}" alt="company-image"
                                     class="mw-200 d-block mx-auto" id="uploadedImage">
                                <input type="file" id="inputImage" name="image" accept="image/*" class="d-none">
                                <label class="mdc-button mdc-button--raised mw-100 mt-3" for="inputImage">
                                    <span class="mdc-button__ripple"></span>
                                    <span class="mdc-button__label">{{__('upload_logo')}}</span>
                                </label>
                                <br>
                                @error('image')
                                <span class="invalid-feedback warn-color d-inline-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        uploadedImage = document.getElementById('uploadedImage');
        imgageInput = document.getElementById('inputImage');
        imgageInput.onchange = evt => {
            const [file] = imgageInput.files
            if (file) {
                uploadedImage.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
