@extends('site.layout.master')

@php
    $side = app()->getLocale() === 'en' ? 'r' : 'l';
    $unSide = app()->getLocale() === 'en' ? 'l' : 'r';
    $name = __($advertising->purpose) . ' ' . (app()->getLocale() == 'en' ? $advertising->venue->title_en : $advertising->venue->title_ar) . ' ' . __('in') . ' ' . (app()->getLocale() == 'en' ? $advertising->area->name_en : $advertising->area->name_ar);
    $tel = \Illuminate\Support\Str::startsWith($advertising->phone_number, '+') ? $advertising->phone_number : "+{$advertising->phone_number}";
    $tel = \Illuminate\Support\Str::startsWith($tel, '+965') ? $tel : str_replace('+', '+965', $tel);
    $tel = str_replace(' ', '', $tel);
@endphp

@section('title' , $name)

@section('meta')
{{--    <meta name="description" content="{{Str::limit($advertising->description, 300, '...')}}">--}}
    <meta name="description" content="{{$advertising->description}}">
@endsection


@section('content')
    {{--    @dd($advertising)--}}
    <!-- Start listing Details Area -->
    <section class="listing-details-area pt-100 pb-70 bg-f7fafd">
        <div class="container">
            <create :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}"
                    :locale="{{json_encode(app()->getLocale())}}"></create>
        </div>
    </section>
    <!-- End listing Details Area -->



    <main>
        <div class="px-3">
            <div class="theme-container">

                <div class="page-drawer-container single-property mt-3">
                    <div class="page-sidenav-content ad-details-container">

                            <div class="blue-search bg-primary blue-search center-xs p-4 d-md-none d-lg-none d-xl-none">
                                <span class="mb-3 text-lg fw-600">{{$name}}</span>
                                @if($advertising->price || $advertising->price == 0)
                                    <div class="w-100 fw-600 mt-2 center-xs">
                                        {{number_format($advertising->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}
                                    </div>
                                @endif

                                <div
                                    class="flex-container mb-2 sm-justify-evenly md-float-{{$side == 'r' ? 'right' : 'left'}} w-100 justify-evenly mt-2">
                                <span class="flex flex-container">
                                    <i class="material-icons mat-icon-sm text-muted m{{$side}}-1 mb-1 text-white">calendar_month</i>
                                    <span class="text-sm text-white">{{$advertising->created_at}}</span>
                                </span>
                                    <span class="flex flex-container">
                                    <i class="material-icons mat-icon-sm text-muted m{{$side}}-1 mb-1 text-white">place</i>
                                    <span
                                        class="text-sm text-white">{{app()->getLocale() == 'en' ? $advertising->area->name_en : $advertising->area->name_ar}}</span>
                                </span>
                                    <span class="flex flex-container">
                                    <i class="material-icons-outlined mat-icon-sm text-muted m{{$side}}-1 text-white" style="font-size: 22px">visibility</i>
                                    <span class="text-sm text-white">{{$advertising->view_count}}</span>
                                </span>
                                </div>
                            </div>


                        <div class="mobile-description-box">
                            @php
                                function uniord($u) {
                                    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
                                    $k1 = ord(substr($k, 0, 1));
                                    $k2 = ord(substr($k, 1, 1));
                                    return $k2 * 256 + $k1;
                                }
                                function is_arabic($str) {
                                    if(mb_detect_encoding($str) !== 'UTF-8') {
                                        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
                                    }
                                    preg_match_all('/.|\n/u', $str, $matches);
                                    $chars = $matches[0];
                                    $arabic_count = 0;
                                    $latin_count = 0;
                                    $total_count = 0;
                                    foreach($chars as $char) {
                                        $pos = uniord($char);
                                        if($pos >= 1536 && $pos <= 1791)
                                            $arabic_count++;
                                        else if($pos > 123 && $pos < 123)
                                            $latin_count++;
                                        $total_count++;
                                    }
                                    if(($arabic_count/$total_count) > 0.6) {
                                        return true;
                                    }
                                }
                                $message = urlencode("السلام عليكم\nاذا ممكن ترسل تفاصيل هذا الإعلان في مستر عقار وشكرا\n" ). url()->current();
                            @endphp
                            <div class="ad-description w-100 fw-600 mt-1"
                                 dir="{{$advertising->description && ! empty($advertising->description) ? (is_arabic($advertising->description) ? 'rtl' : 'ltr') : ''}}">
                                {!! nl2br(e($advertising->description))!!}
                            </div>
                            @if($advertising->price || $advertising->price == 0)
                                <div
                                    class="w-100 fw-600 mt-4 primary-color center-xs d-none d-sm-block d-md-block d-lg-block d-xl-block">
                                    {{number_format($advertising->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}
                                </div>
                            @endif


                            <div class="row flex-container mt-3 justify-content-center d-md-none d-lg-none w-100">
                                <a href="tel:{{$tel}}"
                                   class="mdc-button mdc-button--raised mdc-ripple-upgraded sm-small-button bg-whatsapp incrementClick">
                                    <span class="mdc-button__ripple"></span>
                                    <i class="material-icons mdc-button__icon d-mobile-none">phone</i>
                                    <span class="mdc-button__label">{{$advertising->phone_number}}</span>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone={{str_replace('+', '', $tel)}}&text={{$message}}"
                                   class="col-xs-2 p{{$side}}-0 incrementClick">
                                    <img src="{{asset('images/main/whatsapp.webp')}}"
                                         class="mw-100 d-flex sm-small-button" alt="whatsapp call">
                                </a>
                            </div>
                        </div>

                        <div class="mdc-card p-3 ad-details-gallery">
                            <div class="main-carousel mb-3">
{{--                                @if($advertising->advertising_type === 'premium')--}}
{{--                                    <div class="gallery-badge {{$side == 'l' ? 'right-0' : 'left-0'}}">--}}
{{--                                        <div class="row property-status" v-if="card.advertising_type === 'premium'">--}}
{{--                                            <span class="red text-md">{{__('premium_short')}}</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide center-xs">
                                            <img src="/asset/assets/images/others/transparent-bg.png" alt="slide image"
                                                 data-src="{{$advertising->main_image ? asset($advertising->main_image) : route('image.noimagebig', '') }}"
                                                 zoom="{{$advertising->main_image ? asset($advertising->main_image) : route('image.noimagebig', '') }}"
                                                 class="slide-item swiper-lazy max-hight-500 zoomable">
                                            <div class="swiper-lazy-preloader"></div>
                                        </div>
                                        @foreach((array) optional(json_decode($advertising->other_image))->other_image as $other_image)
                                            <div class="swiper-slide center-xs">
                                                <img src="/asset/assets/images/others/transparent-bg.png"
                                                     alt="slide image" data-src="{{asset($other_image)}}"
                                                     zoom="{{asset($other_image)}}"
                                                     class="slide-item swiper-lazy max-hight-500 zoomable">
                                                <div class="swiper-lazy-preloader"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="swiper-button-prev swipe-arrow mdc-fab mdc-fab--mini primary">
                                        <span class="mdc-fab__ripple"></span>
                                        <span class="mdc-fab__icon material-icons">keyboard_arrow_left</span>
                                    </button>
                                    <button class="swiper-button-next swipe-arrow mdc-fab mdc-fab--mini primary">
                                        <span class="mdc-fab__ripple"></span>
                                        <span class="mdc-fab__icon material-icons">keyboard_arrow_right</span>
                                    </button>
                                </div>
                            </div>

                            <div class="small-carousel">
                                <div id="small-carousel" class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide center-xs">
                                            <img src="/asset/assets/images/others/transparent-bg.png" alt="slide image"
                                                 data-src="{{$advertising->main_image ? asset($advertising->main_image) : route('image.noimagebig', '') }}"
                                                 class="slide-item swiper-lazy height-150 mx-auto">
                                            <div class="swiper-lazy-preloader"></div>
                                        </div>
                                        @foreach((array) optional(json_decode($advertising->other_image))->other_image as $other_image)
                                            <div class="swiper-slide center-xs">
                                                <img src="/asset/assets/images/others/transparent-bg.png"
                                                     alt="slide image" data-src="{{asset($other_image)}}"
                                                     class="slide-item swiper-lazy height-150 mx-auto">
                                                <div class="swiper-lazy-preloader"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mdc-card p-3 mt-3 ad-description-box w-100 d-md-none d-lg-none ad-details-company">
                            <div>
                                <span class="social-icon flex-container rounded-sm border-gray primary-color" id="share"
                                      style="background: #E8E8E7; padding: 2px">
                                    <svg class="material-icons text-muted" style="width:16px;height:16px"
                                         viewBox="0 0 24 24">
                                            <path fill="#517DA6"
                                                  d="M12,1L8,5H11V14H13V5H16M18,23H6C4.89,23 4,22.1 4,21V9A2,2 0 0,1 6,7H9V9H6V21H18V9H15V7H18A2,2 0 0,1 20,9V21A2,2 0 0,1 18,23Z"/>
                                    </svg>
                                </span>
                                <h3 class="uppercase fw-600 mb-2 d-inline">{{$name}}</h3>
                            </div>

                            <div class="row flex-container mt-3 w-100 mx-auto">
                                @if($advertising->user->isCompany)
                                    <a href="{{route('companies.info', [app()->getLocale(),$advertising->user->company_phone,$advertising->user->company_name])}}"
                                       class="col-xs-2 p-0">
                                        @else
                                            <span class="col-xs-2 p-0">
                                @endif
                                    <img
                                        src="{{asset($advertising->user->image_profile ? $advertising->user->image_profile : route('image.user', ''))}}"
                                        class="mw-100 d-inline" alt="profile" style="border-radius: 50%">
                                            @if($advertising->user->isCompany)
                                    </a>
                                    @else
                                        </span>
                                @endif
                                <h4 class="m{{$unSide}}-2">{{$advertising->user->isCompany ? $advertising->user->company_name : $advertising->user->name}}</h4>
                                <a href="tel:{{$tel}}"
                                   class="mdc-button mdc-button--raised mdc-ripple-upgraded col-xs-5 m{{$unSide}}-auto sm-small-button bg-whatsapp incrementClick">
                                    <span class="mdc-button__ripple"></span>
                                    <i class="material-icons mdc-button__icon d-mobile-none">phone</i>
                                    <span class="mdc-button__label">{{$advertising->phone_number}}</span>
                                </a>
                            </div>
                        </div>


                        <div class="mdc-card p-3 mt-3 ad-description-box w-100 ad-details-description" style="overflow: hidden;">
                            <h3 class="uppercase fw-600 mb-2 d-inline-block">{{__('Description')}}</h3>
                            <div class="flex-container mb-2 sm-justify-evenly md-float-{{$side == 'r' ? 'right' : 'left'}} description-box-icons">
                                <span class="flex flex-container m{{$side}}-5">
                                    <i class="material-icons mat-icon-sm text-muted m{{$side}}-1 mb-1 text-gray">calendar_month</i>
                                    <span class="text-sm text-gray">{{$advertising->created_at}}</span>
                                </span>
                                <span class="flex flex-container m{{$side}}-5">
                                    <i class="material-icons mat-icon-sm text-muted m{{$side}}-1 mb-1 text-gray">place</i>
                                    <span
                                        class="text-sm text-gray">{{app()->getLocale() == 'en' ? $advertising->area->name_en : $advertising->area->name_ar}}</span>
                                </span>
                                <span class="flex flex-container">
                                    <i class="material-icons-outlined mat-icon-sm text-muted m{{$side}}-1 text-gray">visibility</i>
                                    <span class="text-sm text-gray">{{$advertising->view_count}}</span>
                                </span>
                            </div>
                            <div class="ad-description w-100 fw-600 mt-1"
                                 dir="{{$advertising->description && ! empty($advertising->description) ? (is_arabic($advertising->description) ? 'rtl' : 'ltr') : ''}}">
                                {!! nl2br(e($advertising->description))!!}
                            </div>
                            @if($advertising->price || $advertising->price == 0)
                                <div class="w-100 fw-600 mt-4 primary-color center-xs d-none d-sm-block d-md-block d-lg-block d-xl-block">
                                    {{number_format($advertising->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}
                                </div>
                            @endif

                            <div class="row flex-container mt-3 justify-content-center d-md-none d-lg-none">
                                <a href="tel:{{$tel}}"
                                   class="mdc-button mdc-button--raised mdc-ripple-upgraded sm-small-button bg-whatsapp incrementClick">
                                    <span class="mdc-button__ripple"></span>
                                    <i class="material-icons mdc-button__icon d-mobile-none">phone</i>
                                    <span class="mdc-button__label">{{$advertising->phone_number}}</span>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone={{str_replace('+', '', $tel)}}&text={{$message}}"
                                   class="col-xs-2 p{{$side}}-0 incrementClick">
                                    <img src="{{asset('images/main/whatsapp.webp')}}"
                                         class="mw-100 d-flex sm-small-button" alt="whatsapp call">
                                </a>
                            </div>
                        </div>
                    </div>
                    <aside class="mdc-drawer mdc-drawer--modal page-sidenav">
                        <a href="#" class="h-0"></a>
                        <div class="mdc-card p-3">
                            <div class="widget">
                                <div class="o-hidden">
                                    <span>
                                        <img src="{{asset($advertising->user->image_profile)}}" alt="agent-4"
                                             class="d-block w-100">
                                    </span>


                                    {{--                                    <div class="p-3">${purpose_lang[card.purpose]} ${card.venue.title_{{app()->getLocale()}} } {{__('in')}} ${card.area.name_{{app()->getLocale()}} }--}}

                                    <h2 class="fw-600 mb-3">{{$name}}</h2>
                                    <p class="row middle-xs"><i class="material-icons primary-color"
                                                                title="Organization">person</i><span
                                            class="mx-2 fw-500">{{$advertising->user->isCompany ? $advertising->user->company_name : $advertising->user->name}}</span>
                                    </p>
                                    <p class="row middle-xs"><i class="material-icons primary-color"
                                                                title="Organization">business</i><span
                                            class="mx-2 fw-500">{{app()->getLocale() == 'en' ? $advertising->venue->title_en : $advertising->venue->title_ar}}</span>
                                    </p>
                                    <p class="row middle-xs"><i class="material-icons primary-color"
                                                                title="Organization">place</i><span
                                            class="mx-2 fw-500">{{app()->getLocale() == 'en' ? $advertising->area->name_en : $advertising->area->name_ar}}</span>
                                    </p>
                                    {{--                                        <p class="row middle-xs"><i class="material-icons primary-color">calendar_month</i><span class="mx-2 fw-500">{{$advertising->created_at}}</span></p>--}}
                                    {{--                                        <p class="row middle-xs"><i class="material-icons primary-color">visibility</i><span class="mx-2 fw-500">{{$advertising->view_count}}</span></p>--}}
                                    @if ($advertising->price)
                                        <p class="row middle-xs"><i class="material-icons primary-color"
                                                                    title="Organization">attach_money</i><span
                                                class="mx-2 fw-500">{{number_format($advertising->price , env('NUMFORMAT' , 0 ))}} {{__('kd_title')}}</span>
                                        </p>
                                    @endif
                                    {{--                                        <a href="tel:{{$tel}}" class="row middle-xs mb-3 decoration-none"><i class="material-icons primary-color">call</i><span class="mx-2 fw-500">{{$advertising->phone_number}}</span></a>--}}
                                    <div class="row">
                                        <a href="tel:{{$tel}}"
                                           class="mdc-button mdc-button--raised mdc-ripple-upgraded mb-3 col-md-10 bg-whatsapp incrementClick">
                                            <span class="mdc-button__ripple"></span>
                                            <i class="material-icons mdc-button__icon">phone</i>
                                            <span class="mdc-button__label">{{$advertising->phone_number}}</span>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?phone={{str_replace('+', '', $tel)}}&text={{$message}}"
                                           class="col-md-2 incrementClick">
                                            <img src="{{asset('images/main/whatsapp.webp')}}" class="mw-100"
                                                 alt="whatsapp call">
                                        </a>
                                    </div>
                                    <div class="row pb-3 p-relative">
                                        <div class="divider"></div>
                                    </div>
                                    @php
                                        $text = $name;
                                        $text = empty($advertising->price) ? $text : $text . ' ' . number_format($advertising->price , env('NUMFORMAT' , 0 )) . __('kd_title');
                                    @endphp
                                    <div class="row between-xs middle-xs">
                                        <div class="row start-xs middle-xs">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"
                                               target="blank" class="social-icon" title="facebook">
                                                <svg class="material-icons text-muted" viewBox="0 0 24 24">
                                                    <path
                                                        d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M18,5H15.5A3.5,3.5 0 0,0 12,8.5V11H10V14H12V21H15V14H18V11H15V9A1,1 0 0,1 16,8H18V5Z"/>
                                                </svg>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{url()->current()}}&text={{$text}}"
                                               target="blank" class="social-icon" title="twitter">
                                                <svg class="material-icons text-muted" viewBox="0 0 24 24">
                                                    <path
                                                        d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M17.71,9.33C18.19,8.93 18.75,8.45 19,7.92C18.59,8.13 18.1,8.26 17.56,8.33C18.06,7.97 18.47,7.5 18.68,6.86C18.16,7.14 17.63,7.38 16.97,7.5C15.42,5.63 11.71,7.15 12.37,9.95C9.76,9.79 8.17,8.61 6.85,7.16C6.1,8.38 6.75,10.23 7.64,10.74C7.18,10.71 6.83,10.57 6.5,10.41C6.54,11.95 7.39,12.69 8.58,13.09C8.22,13.16 7.82,13.18 7.44,13.12C7.81,14.19 8.58,14.86 9.9,15C9,15.76 7.34,16.29 6,16.08C7.15,16.81 8.46,17.39 10.28,17.31C14.69,17.11 17.64,13.95 17.71,9.33Z"/>
                                                </svg>
                                            </a>
                                            <a href="https://web.whatsapp.com/send?text={{url()->current()}}&title={{$text}}"
                                               target="blank" class="social-icon" title="linkedin">
                                                <svg class="material-icons text-muted" style="width:24px;height:24px"
                                                     viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                          d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        @if($advertising->user->isCompany)
                                            <a href="{{route('companies.info', [app()->getLocale(),$advertising->user->company_phone,$advertising->user->company_name])}}"
                                               class="mdc-button">
                                                <span class="mdc-button__ripple"></span>
                                                <span class="mdc-button__label">{{__('company_details')}}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <div class="mdc-drawer-scrim page-sidenav-scrim"></div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        document.querySelector('#share').addEventListener('click', function () {
            if (navigator.share) {
                navigator.share({
                    title: '{{$name}}',
                    text: '{{ \Illuminate\Support\Str::limit($advertising->description, 100, $end='...')}}',
                    url: '{{url()->current()}}'
                })
                    .then(() => console.log('Share complete'))
                    .error((error) => console.error('Could not share at this time', error))
            }
        });



    </script>
    <script>
        window.ViewImage && ViewImage.init('.zoomable');
    </script>
    <script type="module">
        $('.incrementClick').click(function(event) {
            event.preventDefault();

            let payload = {
                advertising_id: {{$advertising->id}},
                user_id: {{optional(auth())->user ?? 'null'}}
            }
            $.post("/api/v1/user/logVisitAdvertising", payload, function(data) {
                $(".result").html( data )
            }).done(() => {
                location.href = event.target.closest('a').href
            });
        });
    </script>
@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('asset/css/libs/dropzone.css') }}">
    <script src="{{asset('/asset/js/libs/view-image.js')}}"></script>
@endsection
