@extends('site.layout.master')
@section('title' , __('contact_title'))

@section('content')

<main class="content-offset-to-top">
{{--    <div class="header-image-wrapper">--}}
{{--        <div class="bg" style="background-image: url('{{ url('') }}/asset/images/others/contact.jpg');"></div>--}}
{{--        <div class="mask"></div>--}}
{{--        <div class="header-image-content offset-bottom">--}}
{{--            <h1 class="title">{{__('contact_us_title')}}</h1>--}}
{{--            <p class="desc">{{__('heretohelp_note')}}</p>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="px-3 mt-7">
        <div class="theme-container">
            <div class="mdc-card main-content-header mb-5">
                <div class="row around-xs">
{{--                    <div class="col-xs-12 col-sm-3">--}}
{{--                        <div class="column center-xs middle-xs text-center">--}}
{{--                            <i class="material-icons mat-icon-lg primary-color">location_on</i>--}}
{{--                            <h3 class="primary-color py-1">{{__('location_title')}} :</h3>--}}
{{--                            @if (app()->getLocale()=='en')--}}
{{--                                <span class="text-muted fw-500">{!! $address !!}</span>--}}
{{--                            @else--}}
{{--                                <span class="text-muted fw-500">{!! $address_ar !!}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-xs-12 col-sm-3">
                        <div class="column center-xs middle-xs text-center">
                            <i class="material-icons mat-icon-lg primary-color">call</i>
                            <h3 class="primary-color py-1">{{__('administrator')}} :</h3>
                            <span> <span class="text-muted fw-500">{{__('administrator')}}: </span><a class="text-muted fw-500" href="tel:{{ $phone2 }}">{{ $phone2 }}</a></span>
                            <span> <span class="text-muted fw-500">{{__('technicalsupport')}}: </span><a class="text-muted fw-500" href="tel:{{ $phone }}">{{ $phone }}</a></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="column center-xs middle-xs text-center">
                            <i class="material-icons mat-icon-lg primary-color">mail_outline</i>
                            <h3 class="primary-color py-1">{{__('email_us') }} :</h3>
                            <a class="text-muted fw-500" href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="column center-xs middle-xs text-center">
                            <i class="material-icons mat-icon-lg primary-color">public</i>
                            <h3 class="primary-color py-1">{{__('visit_us_title')}} :</h3>
                            <a class="text-muted fw-500" href="{{ $website }}">{{ $website }}</a>

                            @include('site.sections.socials')
                        </div>
                    </div>
                    <div class="col-xs-12 mt-3 px-3 p-relative">
                        <div class="divider w-100"></div>
                    </div>
                    <h3 class="w-100 text-center pt-3">{{__('dropaline')}}</h3>
                    <p class="mt-2">{{__('dropaline_note')}}</p>
                    @if((session('status')) == 'success')
                        <div class="alert alert-success center-xs w-100">
                            <strong>{{ __('success_title') }}!</strong> {{__('contact_success')}}!
                        </div>
                    @elseif((session('status')) == 'unsuccess')
                        <div class="alert alert-danger center-xs w-100">
                            <strong>{{ __('un_success_title') }}!</strong> {{__('contact_unsuccess')}}!
                        </div>
                    @endif
                    <form method="post" action="{{ route('message.store' , app()->getLocale()) }}" class="contact-form row">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-4 p-2">
                            <div class="mdc-text-field mdc-text-field--outlined w-100">
                                <input class="mdc-text-field__input @error('name') is-invalid @enderror" name="name" placeholder="{{__('your_name')}}" @if(auth()->check()) value="{{auth()->user()->name}}" @endif value="{{ old('name') }}" required>
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
                        <div class="col-xs-12 col-sm-12 col-md-4 p-2">
                            <div class="mdc-text-field mdc-text-field--outlined w-100">
                                <input type="email" name="email" id="email"  class="mdc-text-field__input @error('email') is-invalid @enderror" required data-error="{{__('email_required')}}" placeholder="{{__('your_email')}}" @if(auth()->check()) value="{{auth()->user()->email}}" @endif value="{{ old('email') }}">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">{{__('email_us')}}</label>
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
                        <div class="col-xs-12 col-sm-12 col-md-4 p-2">
                            <div class="mdc-text-field mdc-text-field--outlined w-100">
                                <input type="text" name="phone_number" id="phone_number"  class="mdc-text-field__input @error('phone_number') is-invalid @enderror" required data-error="{{__('phone_required')}}" placeholder="{{__('your_phone')}}"  @if(auth()->check()) value="{{auth()->user()->mobile}}" @endif value="{{ old('phone_number') }}">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">{{__('phone_number_title')}}</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                            @error('phone_number')
                            <span class="invalid-feedback warn-color">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 p-2">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea w-100">
                                <textarea class="mdc-text-field__input" name="message" id="message" rows="5" required data-error="Please enter your message"  placeholder="{{__('write_your_message')}}">{{ old('message') }}</textarea>
                                <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label class="mdc-floating-label">{{__('your_message_title')}}</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                            @error('message')
                            <span class="invalid-feedback warn-color">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 w-100 py-3 text-center">
                            <button class="mdc-button mdc-button--raised" type="submit">
                                <span class="mdc-button__ripple"></span>
                                <span class="mdc-button__label">{{__('send_title')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
{{--                <div class="mt-5">--}}
{{--                    <iframe--}}
{{--                        width="100%"--}}
{{--                        height="400"--}}
{{--                        style="border:0"--}}
{{--                        loading="lazy"--}}
{{--                        allowfullscreen--}}
{{--                        referrerpolicy="no-referrer-when-downgrade"--}}
{{--                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8269.381942820617!2d47.979978215795796!3d29.374774147096584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf9c83ce455983%3A0xc3ebaef5af09b90e!2sKuwait%20City!5e0!3m2!1sen!2skw!4v1600156454756!5m2!1sen!2skw">--}}
{{--                    </iframe>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</main>

{{--<!-- Map -->--}}
{{--<div class="map-area">--}}
{{--    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8269.381942820617!2d47.979978215795796!3d29.374774147096584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf9c83ce455983%3A0xc3ebaef5af09b90e!2sKuwait%20City!5e0!3m2!1sen!2skw!4v1600156454756!5m2!1sen!2skw"></iframe>--}}
{{--</div>--}}
{{--<!-- End Map -->--}}
{{-- https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8269.381942820617!2d47.979978215795796!3d29.374774147096584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf9c83ce455983%3A0xc3ebaef5af09b90e!2sKuwait%20City!5e0!3m2!1sen!2skw!4v1600156454756!5m2!1sen!2skw --}}
@endsection
