@extends('site.layout.master')

@section('title' , __('edit_ad_title'))

@section('head')
    {{-- {{ dd(@$errors,@$error) }} --}}
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--item {
            width: calc(50% - 0.5em);
        }

        @media (min-width: 30em) {
            .filepond--item {
                width: calc(50% - 0.5em);
            }
        }

        @media (min-width: 50em) {
            .filepond--item {
                width: calc(33.33% - 0.5em);
            }
        }

        .invalid-feedback {
            display: unset !important;
        }

    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

@endsection

@php
    $unSide = app()->getLocale() === 'en' ? 'l' : 'r';
@endphp

@section('content')

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
                @if((session('status')) == 'unsuccess')
                    <div class="alert alert-danger mt-3">
                        <strong>{{__('un_success_title')}}!</strong> {{__('un_success_alert_title')}}!
                    </div>
                @endif
                <div class="py-3">
                    <div class="mdc-card p-3">
                        <div class="mdc-tab-bar-wrapper submit-property">
                            <div class="tab-content tab-content--active">
                                @if (str_contains(request()->path(), 'create'))
                                    <form action="{{ route('site.advertising.store', app()->getLocale()) }}" method="post"
                                          id="sp-basic-form" class="row" enctype="multipart/form-data">

                                        <div class="col-xs-12 p-3">
                                            <h1 class="fw-500 text-center">{{__('create_ad_title')}}</h1>
                                        </div>

{{--                                        @if (!str_contains(request()->path(), 'required_for_rent'))--}}
{{--                                            <a href="{{ route('Main.buyPackage',app()->getLocale()) }}"--}}
{{--                                               class="w-100 px-2 mb-3 primary-color links">--}}
{{--                                                {{__('buy_package_title')}}--}}
{{--                                            </a>--}}
{{--                                        @endif--}}

                                        @else
                                            <form action="{{ route('site.advertising.updateAdvertising', app()->getLocale()) }}"
                                                  method="post" id="sp-basic-form" class="row" enctype="multipart/form-data">
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{@$advertising->id}}">
                                                <div class="col-xs-12 p-3">
                                                    <h1 class="fw-500 text-center">{{__('edit_ad_title')}}</h1>
                                                </div>

                                                @endif
                                                @csrf
                                                {{-- {{ dd($advertising) }} --}}
                                                @if (str_contains(request()->path(), 'required_for_rent'))
                                                    <input type="hidden" name="advertising_type" value="normal">
                                                @else
                                                    @if(env('NORMAL_ADS_FREE' , false))
                                                        @if( old('advertising_type',request()->get('type')) == "premium" )
                                                            <input type="hidden" name="advertising_type" value="premium">
                                                            <label for="premium">{{__('premium_short')}}</label>
                                                            @if($credit['count_premium_advertising'] > 0)
                                                                <span
                                                                    class="text-success m{{$unSide}}-5">{{$credit['count_premium_advertising']}}
                                                                    {{__('remaining_title')}}</span>
                                                            @else
                                                                <span
                                                                    class="text-danger m{{$unSide}}-5">{{$credit['count_premium_advertising']}}
                                                                    {{__('remaining_title')}}</span>
                                                            @endif
                                                            <a href="{{ route('Main.buyPackage',app()->getLocale()) }}" class="w-100 px-2 mb-3 primary-color links">
                                                                {{__('buy_package_title')}}
                                                            </a>
                                                        @else
                                                            <input type="hidden" name="advertising_type" value="normal">
                                                        @endif
                                                    @else
                                                        <div
                                                            class="col-xs-12 mb-2 p-0  @if(!str_contains(request()->path(), 'create')) d-none @endif ">
                                                            <p class="uppercase m-2 fw-500">{{__('ADVERTISE_TYPE')}}</p>
                                                            <div class="mdc-form-field w-100">
                                                                <div class="mdc-radio">
                                                                    <input class="mdc-radio__native-control" type="radio" id="normal"
                                                                           name="advertising_type" value="normal"
                                                                        {{ old('advertising_type', @$advertising->advertising_type) =="normal" ? 'checked' : '' }} {{
                                                    (!@$advertising && $credit['count_normal_advertising'] <= 0) ? 'disabled' : '' }}>
                                                                    <div class="mdc-radio__background">
                                                                        <div class="mdc-radio__outer-circle"></div>
                                                                        <div class="mdc-radio__inner-circle"></div>
                                                                    </div>
                                                                </div>
                                                                <label for="normal">
                                                                    {{__('normal_title')}}
                                                                    @if($credit['count_normal_advertising'] > 0)
                                                                        <span
                                                                            class="text-success m{{$unSide}}-5">{{$credit['count_normal_advertising']}}
                                                                            {{__('remaining_title')}}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-danger m{{$unSide}}-5">{{$credit['count_normal_advertising']}}
                                                                            {{__('remaining_title')}}</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <br>

                                                            <div class="mdc-form-field">
                                                                <div class="mdc-radio">
                                                                    <input class="mdc-radio__native-control" type="radio" id="premium"
                                                                           name="advertising_type" value="premium"
                                                                        {{ old('advertising_type', @$advertising->advertising_type )=="premium" ? 'checked' : '' }} {{
                                                        (!@$advertising && $credit['count_premium_advertising'] <= 0) ? 'disabled' : '' }}>
                                                                    <div class="mdc-radio__background">
                                                                        <div class="mdc-radio__outer-circle"></div>
                                                                        <div class="mdc-radio__inner-circle"></div>
                                                                    </div>
                                                                </div>
                                                                <label for="premium">{{__('premium_short')}}</label>
                                                                @if($credit['count_premium_advertising'] > 0)
                                                                    <span
                                                                        class="text-success m{{$unSide}}-5">{{$credit['count_premium_advertising']}}
                                                                        {{__('remaining_title')}}</span>
                                                                @else
                                                                    <span
                                                                        class="text-danger m{{$unSide}}-5">{{$credit['count_premium_advertising']}}
                                                                        {{__('remaining_title')}}</span>
                                                                @endif
                                                            </div>
                                                            <br>
                                                            @error('advertising_type')
                                                            <span class="invalid-feedback warn-color d-inline-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                @endif
                                                @if (str_contains(request()->path(), 'required_for_rent'))
                                                    <div class="col-xs-12 w-100">
                                                        <h3 class="text-center">{{ __('request_a_property') }}</h3>
                                                        <br>
                                                    </div>
                                                @endif
                                                <div class="col-xs-12   p-2 d-none">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" placeholder="{{__('full_name_title')}}"
                                                               value="{{auth()->user()->name}}" disabled required>
                                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label class="mdc-floating-label"
                                                                       style="">{{__('full_name_title')}}</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12   p-2">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" name="phone_number"
                                                               placeholder="{{__('phone_number_title')}}"
                                                               value="{{ old('phone_number', @$advertising->phone_number ?? auth()->user()->mobile)}}" readonly required>
                                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label class="mdc-floating-label"
                                                                       style="">{{__('phone_number_title')}}</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                    @error('phone_number')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-xs-12   p-2">
                                                    <div class="mdc-select mdc-select--outlined role-list mdc-select--required">
                                                        <input id="cityInput" type="hidden" name="city_id"
                                                               value="{{ old('city_id', @$advertising->city_id) }}">
                                                        <div class="mdc-select__anchor" aria-required="true">
                                                            <i class="mdc-select__dropdown-icon"></i>
                                                            <div class="mdc-select__selected-text"></div>
                                                            <div class="mdc-notched-outline">
                                                                <div class="mdc-notched-outline__leading"></div>
                                                                <div class="mdc-notched-outline__notch">
                                                                    <label class="mdc-floating-label">{{__('city')}}</label>
                                                                </div>
                                                                <div class="mdc-notched-outline__trailing"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                            <ul class="mdc-list">
                                                                @foreach($cities as $city)
                                                                    @php $isOld = old('city_id', @$advertising->city_id) == $city->id;
                                                                    @endphp
                                                                    <li class="mdc-list-item {{ $isOld ? 'mdc-list-item--selected' : '' }}"
                                                                        {{ $isOld ? 'aria-selected="true"' : '' }}
                                                                        data-value="{{ $city->id }}">
                                                                        {{ app()->getLocale() == 'en' ? $city->name_en : $city->name_ar
                                                                        }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @error('city_id')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="col-xs-12   p-2">
                                                    <div class="mdc-select mdc-select--outlined mdc-select--required">
                                                        <input type="hidden" name="area_id" id="area_id"
                                                               value="{{ old('area_id', @$advertising->area_id) }}">
                                                        <div class="mdc-select__anchor" aria-required="true">
                                                            <i class="mdc-select__dropdown-icon"></i>
                                                            <div class="mdc-select__selected-text"></div>
                                                            <div class="mdc-notched-outline">
                                                                <div class="mdc-notched-outline__leading"></div>
                                                                <div class="mdc-notched-outline__notch">
                                                                    <label class="mdc-floating-label">{{__('Area')}}</label>
                                                                </div>
                                                                <div class="mdc-notched-outline__trailing"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                            <ul class="mdc-list" id="areasList">
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @error('area_id')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>



                                                <script type="module">
                                                    // after city select. update areas list with ajax.
                                                    $(document).on('inputUpdated', function(e, event_data) {
                                                        if (event_data[0] === 'city_id') {
                                                            let city_id = event_data[1]
                                                            fill_area_list(city_id)
                                                        }
                                                    })

                                                    $(document).ready(function() {
                                                        let city_id = $('#cityInput').val()
                                                        if (city_id) {
                                                            fill_area_list(city_id)
                                                        }
                                                    })

                                                    function fill_area_list (city_id) {
                                                        $.post('/{{app()->getLocale()}}/areas', {city_id}, function(data, status){
                                                            console.log({status,data})
                                                            if (status === 'success') {
                                                                $('#areasList').empty()
                                                                $('#areasList').parent().parent().find('.mdc-select__selected-text').text('')
                                                                $('#area_id').val('')
                                                                let oldId = '{{ old('area_id', @$advertising->area_id ? @$advertising->area_id : 'null') }}';
                                                                let selectedArea = null;
                                                                $.each(data, function(index, area) {
                                                                    let selectedClass = oldId && area.id == oldId ? 'mdc-list-item--selected' : null;
                                                                    selectedArea = oldId && area.id == oldId ? area.name_{{app()->getLocale()}} : selectedArea;
                                                                    let selectedAttr = oldId && area.id == oldId ? `aria-selected="true"` : null;
                                                                    let option = `<li class="mdc-list-item ${selectedClass}" ${selectedAttr} data-value="${area.id}">${area.name_{{app()->getLocale()}}}</li>`
                                                                    $('#areasList').append(option);
                                                                })
                                                                if (oldId) {
                                                                    console.log($('#areasList').parent().parent().find('.mdc-select__selected-text'), selectedArea)
                                                                    $('#areasList').parent().parent().find('.mdc-select__selected-text').text(selectedArea)
                                                                    $('#area_id').val(oldId)
                                                                    $('#areasList').parent().parent().find('.mdc-select__selected-text').focus()
                                                                    $('#areasList').parent().parent().find('.mdc-select__selected-text').focus()
                                                                    $('#areasList').parent().find('.mdc-select--invalid').removeClass('mdc-select--invalid')
                                                                }
                                                            } else
                                                                console.error('error in get areas with ajax request')
                                                        })
                                                    }
                                                </script>

                                                <div class="col-xs-12   p-2">
                                                    <div class="mdc-select mdc-select--outlined mdc-select--required">
                                                        <input type="hidden" name="venue_type" id="venue_type"
                                                               value="{{ old('venue_type', @$advertising->venue_type) }}">
                                                        <div class="mdc-select__anchor" aria-required="true">
                                                            <i class="mdc-select__dropdown-icon"></i>
                                                            <div class="mdc-select__selected-text"></div>
                                                            <div class="mdc-notched-outline">
                                                                <div class="mdc-notched-outline__leading"></div>
                                                                <div class="mdc-notched-outline__notch">
                                                                    <label
                                                                        class="mdc-floating-label">{{__('property_type')}}</label>
                                                                </div>
                                                                <div class="mdc-notched-outline__trailing"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                            <ul class="mdc-list">
                                                                @foreach($types as $type)
                                                                    @php $isOld = old('venue_type', @$advertising->venue_type) ==
                                                    $type->id;
                                                                    @endphp
                                                                    <li class="mdc-list-item {{ $isOld ? 'mdc-list-item--selected' : '' }}"
                                                                        {{ $isOld ? 'aria-selected="true"' : '' }}
                                                                        data-value="{{@$type->id}}">{{ app()->getLocale() == 'en' ?
                                                        $type->title_en : $type->title_ar }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @error('venue_type')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                @if (str_contains(request()->path(), 'required_for_rent'))
                                                    <input type="hidden" name="purpose" value="required_for_rent">
                                                @else
                                                    <div class="col-xs-12   p-2">
                                                        <div class="mdc-select mdc-select--outlined mdc-select--required">
                                                            <input type="hidden" name="purpose" id="purpose"
                                                                   value="{{ old('purpose', @$advertising->purpose) }}">
                                                            <div class="mdc-select__anchor" aria-required="true">
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <div class="mdc-select__selected-text"></div>
                                                                <div class="mdc-notched-outline">
                                                                    <div class="mdc-notched-outline__leading"></div>
                                                                    <div class="mdc-notched-outline__notch">
                                                                        <label class="mdc-floating-label">{{__('purpose')}}</label>
                                                                    </div>
                                                                    <div class="mdc-notched-outline__trailing"></div>
                                                                </div>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                                <ul class="mdc-list">
                                                                    @foreach($purposes as $purpose)
                                                                        @php $isOld = old('purpose', @$advertising->purpose) == $purpose;
                                                                        @endphp
                                                                        <li class="mdc-list-item {{ $isOld ? 'mdc-list-item--selected' : '' }}"
                                                                            {{ $isOld ? 'aria-selected="true"' : '' }}
                                                                            data-value="{{@$purpose}}">{{ __($purpose) }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @error('purpose')
                                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                @endif

                                                <div class="col-xs-12   p-2">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" name="price"
                                                               value="{{ old('price', @$advertising->price) }}"
                                                               placeholder="{{__('price_title')}} ({{__('kd_title')}})">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label class="mdc-floating-label">{{__('price_title')}}
                                                                    ({{__('kd_title')}})</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                    @error('price')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-xs-12 p-2">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea">
                                            <textarea class="mdc-text-field__input" name="description" rows="5"
                                                      placeholder="{{__('description_title')}}">{{ old('description', @$advertising->description) }}</textarea>
                                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label
                                                                    class="mdc-floating-label">{{__('description_title')}}</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                    @error('description')
                                                    <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>

                                                @if (!str_contains(request()->path(), 'required_for_rent'))
                                                    @if(env('CAN_UPLOAD_VIDEO_IN_SITE' , true))
                                                        <div class="col-xs-12   p-2">
                                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                                @if( old('video' , @$advertising->video) )
                                                                    <input style="visibility: hidden;position: absolute;" name="video"
                                                                           type="text" value="{{ old('video' , @$advertising->video) }}" accept="video/mp4,video/x-m4v,video/*" id="input_video"
                                                                           onchange="$('#name_video').val($(this).val().replace(/C:\\fakepath\\/i, ''))">
                                                                    <input class="mdc-text-field__input"
                                                                           onclick="$('#input_video').attr('type' , 'file').trigger('click');"
                                                                           value="{{ old('video' , @$advertising->video) }}"
                                                                           placeholder="{{__('video')}}" id="name_video">
                                                                @else
                                                                    <input style="visibility: hidden;position: absolute;" name="video"
                                                                           type="file" accept="video/mp4,video/x-m4v,video/*" id="input_video"
                                                                           onchange="$('#name_video').val($(this).val().replace(/C:\\fakepath\\/i, ''))">
                                                                    <input class="mdc-text-field__input"
                                                                           onclick="$('#input_video').trigger('click');"
                                                                           placeholder="{{__('video')}}" id="name_video">
                                                                @endif
                                                                <div class="mdc-notched-outline">
                                                                    <div class="mdc-notched-outline__leading"></div>
                                                                    <div class="mdc-notched-outline__notch">
                                                                        <label class="mdc-floating-label">{{__('video')}}</label>
                                                                    </div>
                                                                    <div class="mdc-notched-outline__trailing"></div>
                                                                </div>
                                                            </div>
                                                            @error('video')
                                                            <span class="invalid-feedback warn-color d-inline-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    @else
                                                        @if( old('video' , @$advertising->video) )
                                                            <input name="video" type="hidden" value="{{ old('video' , @$advertising->video) }}">
                                                        @endif
                                                    @endif

                                                    <div class="col-xs-12 p-2">
                                                        <input type="file" name="other_image[]" class="my-pond"
                                                               accept=".png,.jpg,.jpeg">
                                                        @error('other_image.*')
                                                        <span class="invalid-feedback warn-color d-inline-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                @endif


                                                @if(env('CAN_CHOOSE_LOCATION_IN_SITE' , true))
                                                    <div class="col-xs-12 p-2">
                                                        <div id="map" style="width: 100%;height: 250px;border-radius: 5px;"></div>
                                                        <input type="hidden" id="location_lat" name="location_lat">
                                                        <input type="hidden" id="location_long" name="location_long">
                                                    </div>
                                                @else
                                                    @if( old('location_lat', @$advertising->location_lat) )
                                                        <input type="hidden" value="{{ old('location_lat', @$advertising->location_lat) }}" name="location_lat">
                                                        <input type="hidden" value="{{ old('location_long', @$advertising->location_long) }}" name="location_long">
                                                    @endif
                                                @endif


                                                <div class="col-xs-12 p-2 mt-3 center-xs">
                                                    <button class="mdc-button mdc-button--raised next-tab" type="submit">
                                                        <span class="mdc-button__ripple"></span>
                                                        <span class="mdc-button__label">
                                                @if (str_contains(request()->path(), 'create'))
                                                                {{ __('upload_your_ad') }}
                                                            @else
                                                                {{__('edit_title')}}
                                                            @endif
                                            </span>
                                                    </button>
                                                </div>
                                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
@section('scripts')

    @if(env('CAN_CHOOSE_LOCATION_IN_SITE' , true))
        <script>
            $(document).ready(function () {
                $('#choose-file').change(function () {
                    var i = $(this).prev('label').clone();
                    var file = $('#choose-file')[0].files[0].name;
                    $(this).prev('label').text(file);
                });
            });
            window.onload = function() {
                var map = L.map('map').setView([{{ old('location_lat', (isset($advertising) ? $advertising->location_lat : 29.303844 )) }}, {{ old('location_long', (isset($advertising) ? $advertising->location_long : 47.979262 )) }}], 12.5);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
                var marker = L.marker([{{ old('location_lat', (isset($advertising) ? $advertising->location_lat : 29.303844 )) }}, {{ old('location_long', (isset($advertising) ? $advertising->location_long : 47.979262 )) }}],{
                    draggable: true,
                    autoPan: true
                }).addTo(map);

                const options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                function success(pos) {
                    const crd = pos.coords;
                    $('#location_long').val(crd.longitude.toFixed(6));
                    $('#location_lat').val(crd.latitude.toFixed(6));
                    marker.setLatLng([ crd.latitude, crd.longitude ]);
                    map.setView(marker.getLatLng(),map.getZoom());
                }
                function error(err) {
                    console.warn(`ERROR(${err.code}): ${err.message}`);
                }
                @if( old('location_lat', (isset($advertising) ? $advertising->location_lat : null )) == null  )
                    navigator.geolocation.getCurrentPosition(success, error, options);
                @else
                    $('#location_long').val({{ old('location_long', @$advertising->location_long) }});
                    $('#location_lat').val({{ old('location_lat', @$advertising->location_lat) }});
                @endif
                marker.on("drag", function(e) {
                    var marker = e.target;
                    var position = marker.getLatLng();
                    map.panTo(new L.LatLng(position.lat, position.lng));
                    $('#location_long').val(position.lng.toFixed(6));
                    $('#location_lat').val(position.lat.toFixed(6));
                });
            };
        </script>
    @endif

    @if (!str_contains(request()->path(), 'required_for_rent'))
        <!-- include FilePond library -->
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

        <!-- include FilePond plugins -->
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

        <!-- include FilePond jQuery adapter -->
        <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

        <script>
            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);

            // Single image seletors
            $('.my-pond').filepond({
                credits: {
                    label: '',
                    url: ''
                },

                labelIdle: "{{ __('add_photos')  }} ({{ __('optional')  }})"
            });
            // Set allowMultiple property to true
            $('.my-pond').filepond('allowMultiple', true);
            $('.my-pond').filepond('storeAsFile', true);

            @php
                $other_images = (array)json_decode(old( 'replace_other_image', @$advertising->other_image) , true);
            @endphp

            @if (@$other_images && count($other_images))
            @foreach($other_images as $i1 => $files )
            @foreach((array)$files as $i2 => $file )
            @if ($file)
            $('.my-pond').filepond('addFile', "{{ @$file  }}").then(function(file){
                console.log('file added', file);
            });
            @endif
            @endforeach
            @endforeach
            @endif


            @if ( old( 'replace_main_image' , @$advertising->main_image) )
            $('.my-pond').filepond('addFile', "{{ old( 'replace_main_image' , @$advertising->main_image)  }}").then(function(file){
                console.log('file added', file);
            });
            @endif

        </script>
    @endif

@endsection
