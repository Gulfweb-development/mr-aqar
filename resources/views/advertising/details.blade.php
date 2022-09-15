@extends('layouts.admin', ['crumbs' => [
    'Advertising Details' => route('advertising.details',$advertising->id)],
    'title' => __('Update Advertising')
])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('fancybox/source/jquery.fancybox.css')}}">
    <style>
        .select2 {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection


@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-22">
                        <a href="{{route("advertising.index")}}"><button  style="margin-top: 35px" class="btn btn-danger"><i class="fa fa-fw fa-arrow-left"></i> {{__('Back')}}</button></a>
                    </div>

                </div>
            </div>
            <form method="post" action="{{route('advertising.update')}}" id="advertising-edit-form">
                <div class="card-body">



                    <h5>{{__('Update Advertising')}}</h5>
                    <br><br>


                    @csrf
                    <input type="hidden" value="{{$advertising->id}}" name="id">
                    <div class="row">
                        <div class="col">


{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Title')}}</label>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="text" name="title_en" class="form-control  @error('title_en') is-invalid @enderror" id="title_en"  value="{{ $advertising->title_en }}" required>--}}
{{--                                    @error('title_en')--}}
{{--                                    <div class="help-block text-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Title Ar')}}</label>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="text" name="title_ar" class="form-control  @error('title_ar') is-invalid @enderror" id="title_ar"  value="{{ $advertising->title_ar }}">--}}
{{--                                    @error('title_ar')--}}
{{--                                    <div class="help-block text-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Price')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="price" class="form-control  @error('price') is-invalid @enderror" id="price"  value="{{ $advertising->price }}" required>
                                    @error('price')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <input type="hidden" name="type" value="Residential">



                            <div class="form-group row">
                                <label for="venue_type" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Venue Type')}}</label>
                                <div class="col-sm-6">
                                    <select id="venue_type" name="venue_type" class="form-control  ">
                                        @foreach($venueType as $venType)
                                            <option @if($advertising->venue_type==$venType->title_en) selected @endif value="{{$venType->id}}">{{$venType->title_en}}</option>
                                        @endforeach
                                    </select>
                                    {{--                            <input type="text" name="venue_type" class="form-control  @error('venue_type') is-invalid @enderror" id="venue_type"  value="{{ $advertising->venue_type }}">--}}
                                    @error('venue_type')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="purpose" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('purpose')}}</label>
                                <div class="col-sm-6">
                                    <select id="purpose" name="purpose" class="form-control  ">
                                        <option @if($advertising->purpose=='rent') selected @endif value="rent">{{__('rent')}}</option>
                                        <option @if($advertising->purpose=='sell') selected @endif value="sell">{{__('sell')}}</option>
                                        <option @if($advertising->purpose=='exchange') selected @endif value="exchange">{{__('exchange')}}</option>
                                        <option @if($advertising->purpose=='required_for_rent') selected @endif value="required_for_rent">{{__('required_for_rent')}}</option>
                                    </select>
                                    @error('purpose')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Advertising Type')}}</label>
                                <div class="col-sm-6">
                                    <select name="advertising_type" class="form-control ">
                                        <option @if($advertising->advertising_type=="normal") selected @endif value="normal">Normal</option>
                                        <option @if($advertising->advertising_type=="premium") selected @endif value="premium">Premium</option>
                                    </select>
                                    @error('advertising_type')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Phone Number')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone_number" class="form-control  @error('phone_number') is-invalid @enderror" id="phone_number"  value="{{ $advertising->phone_number?? optional($advertising->user)->mobile }}" required>
                                    @error('phone_number')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 20px"><span class="text-danger"></span> {{__('Description')}}</label>
                                <div class="col-sm-6">
                                    <textarea name="description" class="form-control  @error('description') is-invalid @enderror" rows="4" >{{ $advertising->description }}</textarea>
                                    @error('description')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
<?php /*
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Surface(M2)')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="surface" class="form-control  @error('surface') is-invalid @enderror" id="surface"  value="{{$advertising->surface }}" required>
                                    @error('surface')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Rooms')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_rooms" class="form-control  @error('number_of_rooms') is-invalid @enderror" id="number_of_rooms"  value="{{ $advertising->number_of_rooms }}" >
                                    @error('number_of_rooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Bathrooms')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_bathrooms" class="form-control  @error('number_of_bathrooms') is-invalid @enderror" id="number_of_bathrooms"   value="{{ $advertising->number_of_bathrooms }}"  >
                                    @error('number_of_bathrooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Parking')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_parking" class="form-control  @error('number_of_parking') is-invalid @enderror" id="number_of_parking"   value="{{ $advertising->number_of_parking }}" >
                                    @error('number_of_parking')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Balcony ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_balcony" class="form-control  @error('number_of_balcony') is-invalid @enderror" id="number_of_balcony"  value="{{ $advertising->number_of_balcony }}" >
                                    @error('number_of_balcony')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Miad Rooms ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_miad_rooms" class="form-control  @error('number_of_miad_rooms') is-invalid @enderror" id="number_of_miad_rooms"  value="{{ $advertising->number_of_miad_rooms }}" >
                                    @error('number_of_miad_rooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Floor ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_floor" class="form-control  @error('number_of_floor') is-invalid @enderror" id="number_of_floor"  value="{{ $advertising->number_of_floor }}" >
                                    @error('number_of_floor')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 20px"><span class="text-danger"></span> {{__('Description')}}</label>
                                <div class="col-sm-6">
                                    <textarea  name="description" class="form-control  @error('description') is-invalid @enderror" rows="4" >
                                        {!! $advertising->description !!}
                                    </textarea>
                                    @error('description')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

*/ ?>
                            <br>
                            <hr>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Main Image')}}</label>
                                <div class="col-sm-9">
                                    <div class="col-md-4 text-center">
                                        <img id="main_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;"  @if($advertising->main_image!=null) src="{{asset($advertising->main_image)}}"  @else src="{{asset('images/noimage.png')}}"  @endif  >
                                        <a href="/filemanager/dialog.php?type=1&field_id=main_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>
                                        <button onclick="clearImage('main');" type="button" class="btn btn-danger">Remove Image</button>
                                        <input type="hidden" @if($advertising->main_image!=null) value="{{asset($advertising->main_image)}}"  @else value=""  @endif  name="main_image" id="main_image" class="form-control">
                                    </div>
                                </div>
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Floor Plan')}}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="col-md-4 text-center">--}}
{{--                                        <img id="floor_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;"  @if($advertising->floor_plan!=null) src="{{asset($advertising->floor_plan)}}"  @else src="{{asset('images/noimage.png')}}"  @endif  >--}}
{{--                                        <a href="/filemanager/dialog.php?type=1&field_id=floor_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>--}}
{{--                                        <button onclick="clearImage('floor');" type="button" class="btn btn-danger">Remove Image</button>--}}
{{--                                        <input type="hidden" @if($advertising->floor_plan!=null) value="{{asset($advertising->floor_plan)}}"  @else value=""  @endif  name="floor_plan" id="floor_image" class="form-control">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            <div id="deleted_images"></div>
                            <script type="text/javascript">
                                let delInput = link => `<input type="hidden" name="deleted_images[]" value="${link}">`

                                function deletedImage(link) {
                                    $('#deleted_images').append(delInput(link))
                                }
                            </script>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Other Image')}}</label>

                                <div class="col-sm-9">

                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img id="other_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;" @if(isset($imagePath) && isset($imagePath->other_image1) && $imagePath->other_image1!="") src="{{asset($imagePath->other_image1)}}"  @else  src="{{asset('images/noimage.png')}}" @endif >
                                            <a href="/filemanager/dialog.php?type=1&field_id=other_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>
                                            <button onclick="clearImage('other');" type="button" class="btn btn-danger">Remove Image</button>
                                            <input type="hidden"  name="other_image" id="other_image" class="form-control">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 50px">
                                            @foreach((array) optional($imagePath)->other_image as $key => $path)
                                                @if($path!="")
                                                    <div  id="{{'image'.$key}}">
                                                        <img src="{{asset($path)}}" style="width:100px;height:100px"/>
                                                        <button onclick="$('#image'+'{{$key}}').remove(); deletedImage('{{$path}}')" type="button" class="bg-warn border-0">
                                                            <span class="material-icons-outlined">delete</span>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <br>
                            <hr/>



{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label"  @if(isset($advertising->video) && $advertising->video!="") style="margin-top: 130px" @else style="margin-top: 30px" @endif><span class="text-danger"></span> {{__('Video')}}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-4 text-center"   @if(isset($advertising->video) && $advertising->video!="") style="margin-top: 100px" @endif>--}}
{{--                                            <a href="/filemanager/dialog.php?type=3&field_id=video" data-fancybox-type="iframe" class="btn btn-info fancy">Select Video</a>--}}
{{--                                            <button onclick="clearVideo();" type="button" class="btn btn-danger">Remove Video</button>--}}
{{--                                            <input  @if(isset($advertising->video)) value="{{$advertising->video}}"  @else value=""  @endif  name="video" id="video" class="form-control">--}}
{{--                                        </div>--}}
{{--                                        @if(isset($advertising->video) && $advertising->video!="")--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <video width="320" height="240" controls>--}}
{{--                                                    <source src="{{asset($advertising->video)}}" type="video/mp4">--}}
{{--                                                    Your browser does not support the video tag.--}}
{{--                                                </video>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <hr>--}}
{{--                            <br>--}}

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <div class="col">
                                        <div class="checkbox">
                                            <input type="checkbox" @if($advertising->status=="accepted")  checked  @endif     name="status" id="status">
                                            <label for="status">Accept</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row   "  @if($advertising->status=="accepted")  style="display: none" @endif  id="message_reject_box">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 20px"><span class="text-danger"></span> {{__('Reject Message')}}</label>
                                <div class="col-sm-6">
                                <textarea  name="reject_message" class="form-control  @error('reject_message') is-invalid @enderror" rows="4" >
                                    {!! $advertising->reject_message !!}
                                </textarea>
                                    @error('reject_message')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    <a href="{{route('advertising.index')}}" class="btn btn-light">{{__('Cancel')}}</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('fancybox/source/jquery.fancybox.js')}}" ></script>

    <script>
        function destroy(itemId) {
            swal({
                title: "{{__('Are you sure you want to delete this item?')}}",
                text: "{{__('Be aware that deletion process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('destroy-form-'+itemId).submit();
                }
            });
        }
        function accept(id) {
            swal({
                title: "{{__('Are you sure you want to accept item?')}}",
                text: "{{__('Be aware that deletion process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Accept')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('accept-form-'+id).submit();
                }
            });
        }
        function responsive_filemanager_callback(field_id){

            var url=jQuery('#'+field_id).val().split(",");
            if (Array.isArray(url)) {
                url= url[0].replace("[","")
                url= url.replace("\"","");
                url= url.replace("\"","");
                $("#"+field_id+"_path").attr('src', url);
            } else {
                $("#"+field_id+"_path").attr('src', url);
            }

        }
        function clearImage(type) {
            var url = "{{route('image.noimage', '')}}";
            $("#" + type + "_image_path").attr('src', url);

            $('<input>').attr({
                type: 'hidden',
                name: 'delete_main',
                value: 1,
            }).appendTo('form#advertising-edit-form')
        }
        function clearVideo(){
            $("#video").val("");
        }
        $(function () {
            $('.fancy').fancybox({
                'width'		: 900,
                'height'	: 600,
                'type'		: 'iframe',
                'autoScale'    	: false
            });
            $("#status").on("change",function () {
                if($(this).prop("checked")){
                    $("#message_reject_box").hide();
                }else{
                    $("#message_reject_box").show();
                }
            });
            $("._type").on("change",function () {
                    var v=$(this).val();
                    $.ajax({
                            url: "/admin/getVenueTypeByType/"+v,
                            method: 'get',
                            success: function(result){
                                $("#venue_type").empty();
                                $.each(result, function(key,item) {
                                    $('#venue_type')
                                        .append($("<option></option>")
                                            .attr("value",item.title_en)
                                            .text(item.title_en));
                                });
                            }});
                    });
        });
    </script>
@endsection

