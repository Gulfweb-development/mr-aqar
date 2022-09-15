@extends('layouts.admin', ['crumbs' => [
    __('Members') => route('members.index'),
    __('Members Advertising List') => route('members.advertisingList', $user)]
, 'title' => __('Members Advertising List')])

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger col-sm-12">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <div class="container">
        <div class="row">



                @foreach($advertises as $ad)
                    <div class="col-lg-4 col-sm-12 col-md-6 f_left">
                        <div class="single-listing-item">
                            <div class="listing-image">
                                <a href="{{ '/'.app()->getLocale().'/advertising/' . $ad->hash_number . '/details' }}" target="_blank" class="d-block">
                                    <img  src="{{ asset($ad->main_image) }}" class=" ad-image-responsive w-100" alt="image">
                                </a>
                            </div>

                            <div class="listing-content">
                                <div class="listing-author d-flex align-items-center">
                                    <img src="{{ asset($ad->user->image_profile) }}" class="rounded-circle mr-2" alt="image">
                                    <span>{{ $ad->user->name }}</span>
                                </div>


                                <h3><a href="{{'/'. app()->getLocale(). '/advertising/' . $ad->hash_number . '/details' }}"
                                       class="d-inline-block" target="_blank">{{ app()->getLocale()==='en'? $ad->title_en : $ad->title_ar}}</a></h3>

                                <span class="location"><i class="bx bx-map"></i>{{ app()->getLocale()==='en'?$ad->city->name_en . " - " . $ad->area->name_en:$ad->city->name_ar . " - " . $ad->area->name_ar }}</span>
                            </div>

                            <div class="listing-box-footer">
                                <div class="d-flex align-items-center justify-content-between">

                                </div>
                            </div>

                            <div class="listing-badge">
                                @if($ad->advertising_type == "premium") {{__('premium_title')}}
                                @elseif($ad->advertising_type == "normal") {{__('normal_title')}}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>
    </div>



@endsection
