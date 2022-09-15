@extends('layouts.admin', ['crumbs' => [
    'Advertising' => route('advertising.index'),
    __('View Details') => route('advertising.view', $advertising->id)]
, 'title' => __('Detail Advertising')])
@section('content')


        <div class="card col-md-6 mx-auto" style="margin-bottom: 2px">
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <h4>{{__('General Information')}}</h4>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Title')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->title_en}}<br>{{$advertising->title_ar}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Advertising Type')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->advertising_type}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Description')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->description}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Price')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->price}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Date')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->created_at}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Phone Number')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->phone_number}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Hash Number')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->hash_number}}</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="card col-md-6 mx-auto" style="margin-bottom: 2px">
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <h4>{{__('Location Information')}}</h4>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Area')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{optional($advertising->area)->name_en}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('City')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{optional($advertising->city)->name_en}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Venue Type')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->venue_type}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('purpose')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->purpose}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Type')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{$advertising->type}}</label>
                            </div>
                        </div>
                        @if(isset($advertising->location_lat))
                           <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">   <a  href="https://www.google.com/maps/search/ {{$advertising->location_lat}},{{$advertising->location_long }}" class="btn btn-info" style="color: white">View On Map</a></label>
                            <div class="col-sm-3">

                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="card {{-- col-md-6 --}} col-md-12 mx-auto" style="margin-bottom: 2px">
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <h4>{{__('User Information')}}</h4>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Name')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{optional($advertising->user)->name}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Mobile')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ optional($advertising->user)->mobile}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"> {{__('Package')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{optional(optional($advertising->user)->package)->title_en??"----"}}</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

{{-- <div class="card col-md-12 mx-auto" style="margin-bottom: 2px">--}}
{{--    <div class="card-body">--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}

{{--                <h4>{{__('Other Details')}}</h4>--}}
{{--                <hr>--}}
{{--                <br>--}}
{{--                <div class="form-group row">--}}
{{--                    <label for="name" class="col-sm-3 col-form-label"> {{__('Number Of Rooms')}}</label>--}}
{{--                    <div class="col-sm-3">--}}
{{--                        <label class="col-form-label text-info">{{$advertising->number_of_rooms}}</label>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row">--}}
{{--                    <label for="name" class="col-sm-3 col-form-label"> {{__('Number Of Bathrooms')}}</label>--}}
{{--                    <div class="col-sm-3">--}}
{{--                        <label class="col-form-label text-info">{{$advertising->number_of_bathrooms}}</label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group row">--}}
{{--                    <label for="name" class="col-sm-3 col-form-label"> {{__('Number Of Master Rooms')}}</label>--}}
{{--                    <div class="col-sm-3">--}}
{{--                        <label class="col-form-label text-info">{{$advertising->number_of_master_rooms}}</label>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


         <div class="card col-md-12 mx-auto" style="margin-bottom: 2px">
        <div class="card-body">
        <div class="row">
            <div class="col">

                <h4>{{__('Gallery Information')}}</h4>
                <hr>
                <br>
                <div class="form-group row">
                    <label for="name" style="margin-top: 40px;" class="col-sm-3 col-form-label"> {{__('Main Image')}}</label>
                    <div class="col-sm-3">
                        <img id="main_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;" @if($advertising->main_image!=null) src="{{asset($advertising->main_image)}}"  @else src="{{asset('images/noimage.png')}}"  @endif  >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" style="margin-top: 40px;" class="col-sm-3 col-form-label"> {{__('Other Image')}}</label>
                    <div class="col-md-9">
                       <div class="row">
                       @foreach((array) optional($imagePath)->other_image as $image=>$path)
                           <div class="col-sm-3">
                               <img  id="main_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;" src="{{asset($path)}}"    >
                           </div>
                        @endforeach
                       </div>
                    </div>
                </div>
                @if(isset($advertising->video) && $advertising->video!="")
                <div class="form-group row">
                    <label for="name" style="margin-top: 40px;" class="col-sm-3 col-form-label"> {{__('Video')}}</label>
                    <div class="col-sm-3">

                                <video width="320" height="240" controls>
                                    <source src="{{asset($advertising->video)}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>


                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

        <div class="card col-md-12 mx-auto" >
            <div class="card-footer">
                <a href="{{route('advertising.index')}}" class="btn btn-danger">{{__('Back To List')}}</a>
                <a href="{{route('advertising.details',$advertising->id)}}" class="btn btn-info">{{__('Edit')}}</a>
            </div>
         </div>

@endsection
