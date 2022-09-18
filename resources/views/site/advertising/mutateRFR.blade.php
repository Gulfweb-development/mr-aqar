@extends('site.layout.master')

@section('title' , __('add_ad_title'))

@php
$unSide = app()->getLocale() === 'en' ? 'l' : 'r';
@endphp

@section('content')
{{-- {{ dd($errors) }} --}}
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
                            @if (@$advertising->id)
                            <form action="{{ route('site.advertising.updateAdvertising', app()->getLocale()) }}" method="post"
                                id="sp-basic-form" class="row">
                                @method('PUT')
                                @else
                                <form action="{{  route('site.advertising.storeRFR', app()->getLocale())  }}"
                                    method="post" id="sp-basic-form" class="row">
                                    @endif
                                    @csrf
                                    <div class="col-xs-12 p-3">
                                        <h1 class="fw-500 text-center">{{ __('main.request_a_property_in_kuwait')}}</h1>
                                    </div>
                                    <input type="hidden" name="purpose" id="purpose" value="required_for_rent">
                                    <input type="hidden" name="advertising_type" id="advertising_type" value="normal">
                                    <div class="col-xs-12 col-sm-6 p-2">
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

                                    {{-- <div class="col-xs-12 col-sm-6 p-2">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" name="phone_number"
                                                placeholder="{{__('phone_number_title')}}"
                                                value="{{ old('phone_number', auth()->user()->mobile)}}" required>
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
                                    </div> --}}

                                    <div class="col-xs-12 col-sm-6 p-2">
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
                                                    @php $isOld = old('city_id' , @$advertising->city_id) == $city->id;
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

                                    <div class="col-xs-12 col-sm-6 p-2">
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
                                            if (typeof city_id === 'string' && city_id !== '') {
                                                fill_area_list(city_id)
                                            }
                                        })

                                        function fill_area_list (city_id) {
                                            $.post('/{{app()->getLocale()}}/areas', {city_id}, function(data, status){
                                                if (status === 'success') {
                                                    $('#areasList').empty()
                                                    $('#areasList').parent().parent().find('.mdc-select__selected-text').text('')
                                                    $('#area_id').val('')
                                                    let oldId = parseInt('{{ old('area_id',  @$advertising->area_id) }}');
                                                    let selectedArea = null ;
                                                    $.each(data, function(index, area) {
                                                        let selectedClass = oldId && area.id === oldId ? 'mdc-list-item--selected' : null;
                                                        selectedArea = oldId && area.id === oldId ? area.name_{{app()->getLocale()}} : selectedArea;
                                                        let selectedAttr = oldId && area.id === oldId ? `aria-selected="true"` : null;
                                                        let option = `<li class="mdc-list-item ${selectedClass}" ${selectedAttr} data-value="${area.id}">${area.name_{{app()->getLocale()}}}</li>`
                                                        $('#areasList').append(option);
                                                    })
                                                    if (oldId) {
                                                        $('#areasList').parent().parent().find('.mdc-select__selected-text').text(selectedArea)
                                                        $('#area_id').val(oldId)
                                                    }
                                                } else
                                                    console.error('error in get areas with ajax request')
                                            })
                                        }
                                    </script>

                                    <div class="col-xs-12 col-sm-6 p-2">
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
                                                    $type->id; @endphp
                                                    <li class="mdc-list-item {{ $isOld ? 'mdc-list-item--selected' : '' }}"
                                                        {{ $isOld ? 'aria-selected="true"' : '' }}
                                                        data-value="{{$type->id}}">{{ app()->getLocale() == 'en' ?
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

                                    <div class="col-xs-12 col-sm-6 p-2">
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

                                    <div class="col-xs-12 p-2 mt-3 center-xs">
                                        <button class="mdc-button mdc-button--raised next-tab" type="submit">
                                            <span class="mdc-button__ripple"></span>
                                            <span class="mdc-button__label">{{__('Submit')}}</span>
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
<script src="{{ asset('asset/js/libs/dropzone.js') }}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
        $(document).ready(function () {
            $("#property-images").dropzone({
                maxFiles: 2000,
                url: "{{ route('site.advertising.ajax_file_upload_handler' , app()->getLocale() ) }}",
                success: function (file, response) {
                    $('#files').append('<input type="hidden" name="other_images_link[]" value="'+response+'">');
                }
            });
        })

</script>


@endsection
@section('header')
<link rel="stylesheet" href="{{ asset('asset/css/libs/dropzone.css') }}">
@endsection
