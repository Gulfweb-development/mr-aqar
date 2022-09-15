@extends('layouts.admin', ['crumbs' => [
    'Create Advertising' => route('advertising.createForm')],
    'title' => __('Create Advertising')
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
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-22">
                        <a href="{{route("advertising.index")}}"><button  style="margin-top: 35px" class="btn btn-danger"><i class="fa fa-fw fa-arrow-left"></i> {{__('Back')}}</button></a>
                    </div>

                </div>
            </div>
            <form method="post" action="{{route('advertising.create')}}">
                <div class="card-body">

                    @csrf
                    <div class="row">
                        <div class="col">


                            <div class="form-group row">
                                <label for="user" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('User')}}</label>
                                <div class="col-sm-6">
                                    <select id="user"  style="width:100%;height:100%"  name="user_id" class="form-control">
                                        <option selected disabled>{{__('Select an user')}}</option>
                                        @foreach($users as $u)
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('area_id')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="area" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Area')}}</label>
                                <div class="col-sm-6">
                                    <select name="area_id" style="width:100%;height:100%" id="area" class="form-control">
                                        <option selected disabled>{{__('Select an area')}}</option>
                                        @foreach($area as $area)
                                            <option value="{{$area->id}}">{{$area->name_en}}</option>
                                        @endforeach
                                    </select>
                                    @error('area_id')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Title ')}}</label>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="text" name="title_en" class="form-control  @error('title_en') is-invalid @enderror" id="title_en"   required>--}}
{{--                                    @error('title_en')--}}
{{--                                    <div class="help-block text-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Title Ar')}}</label>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="text" name="title_ar" class="form-control  @error('title_ar') is-invalid @enderror" id="title_ar" >--}}
{{--                                    @error('title_ar')--}}
{{--                                    <div class="help-block text-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Price')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="price" class="form-control  @error('price') is-invalid @enderror" id="price"   required>
                                    @error('price')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <input type="hidden" name="type" value="Residential">



                            <div class="form-group row">
                                <label for="venue_type" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Venue Type')}}</label>
                                <div class="col-sm-6">
                                    <select id="venue_type" name="venue_type" class="form-control">
                                        <option selected disabled>{{__('Select a venue type')}}</option>
                                        @foreach($venueType as $venType)
                                            <option  value="{{$venType->id}}">{{$venType->title_en}}</option>
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
                                        <option selected disabled>{{__('Select a purpose')}}</option>
                                        <option  value="rent">{{__('rent')}}</option>
                                        <option  value="sell">{{__('sell')}}</option>
                                        <option  value="exchange">{{__('exchange')}}</option>
                                        <option  value="required_for_rent">{{__('required_for_rent')}}</option>
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
                                        <option selected disabled>{{__('Select an advertising type')}}</option>
                                        <option  value="normal">Normal</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                    @error('advertising_type')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Phone Number')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone_number" class="form-control  @error('phone_number') is-invalid @enderror" id="phone_number"   required>
                                    @error('phone_number')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

<?php /*
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Surface(M2)')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="surface" class="form-control  @error('surface') is-invalid @enderror" id="surface"   required>
                                    @error('surface')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Rooms')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone_number" class="form-control  @error('number_of_rooms') is-invalid @enderror" id="number_of_rooms"   >
                                    @error('number_of_rooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Bathrooms')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_bathrooms" class="form-control  @error('number_of_bathrooms') is-invalid @enderror" id="number_of_bathrooms"    >
                                    @error('number_of_bathrooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Parking')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_parking" class="form-control  @error('number_of_parking') is-invalid @enderror" id="number_of_parking"    >
                                    @error('number_of_parking')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Balcony ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_balcony" class="form-control  @error('number_of_balcony') is-invalid @enderror" id="number_of_balcony"  >
                                    @error('number_of_balcony')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Miad Rooms ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_miad_rooms" class="form-control  @error('number_of_miad_rooms') is-invalid @enderror" id="number_of_miad_rooms"  >
                                    @error('number_of_miad_rooms')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Number Of Floor ')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="number_of_floor" class="form-control  @error('number_of_floor') is-invalid @enderror" id="number_of_floor"  >
                                    @error('number_of_floor')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
*/ ?>



                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 20px"><span class="text-danger"></span> {{__('Description')}}</label>
                                <div class="col-sm-6">
                                    <textarea  name="description" class="form-control  @error('description') is-invalid @enderror" rows="4" >

                                    </textarea>
                                    @error('description')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <hr>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Main Image')}}</label>
                                <div class="col-sm-9">
                                    <div class="col-md-4 text-center">
                                        <img id="main_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;"  src="{{asset('images/noimage.png')}}"   >
                                        <a href="/filemanager/dialog.php?type=1&field_id=main_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>
                                        <button onclick="clearImage('main');" type="button" class="btn btn-danger">Remove Image</button>
                                        <input type="hidden"  value="" name="main_image" id="main_image" class="form-control">
                                    </div>
                                </div>
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Floor Plan')}}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="col-md-4 text-center">--}}
{{--                                        <img id="floor_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;"  src="{{asset('images/noimage.png')}}"   >--}}
{{--                                        <a href="/filemanager/dialog.php?type=1&field_id=floor_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>--}}
{{--                                        <button onclick="clearImage('floor');" type="button" class="btn btn-danger">Remove Image</button>--}}
{{--                                        <input type="hidden"    value=""   name="floor_plan" id="floor_image" class="form-control">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 100px"><span class="text-danger"></span> {{__('Other Image')}}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img id="other_image_path" style="margin: 20px 0;border: 8px double #ccc; width: 280px;height: 160px;"  src="{{asset('images/noimage.png')}}"  >
                                            <a href="/filemanager/dialog.php?type=1&field_id=other_image" data-fancybox-type="iframe" class="btn btn-info fancy">Select Image</a>
                                            <button onclick="clearImage('other');" type="button" class="btn btn-danger">Remove Image</button>
                                            <input type="hidden"  name="other_image" id="other_image" class="form-control">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 50px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <hr/>



{{--                            <div class="form-group row">--}}
{{--                                <label for="mobile" class="col-sm-2 col-form-label" ><span class="text-danger"></span> {{__('Video')}}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-4 text-center"  >--}}
{{--                                            <a href="/filemanager/dialog.php?type=3&field_id=video" data-fancybox-type="iframe" class="btn btn-info fancy">Select Video</a>--}}
{{--                                            <button onclick="clearVideo();" type="button" class="btn btn-danger">Remove Video</button>--}}
{{--                                            <input   name="video" id="video" class="form-control">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <hr>--}}
{{--                            <br>--}}

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <div class="col">
                                        <div class="checkbox">
                                            <input type="checkbox"    name="status" id="status">
                                            <label for="status">Accept</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row   "    id="message_reject_box">
                                <label for="mobile" class="col-sm-2 col-form-label" style="margin-top: 20px"><span class="text-danger"></span> {{__('Reject Message')}}</label>
                                <div class="col-sm-6">
                                <textarea  name="reject_message" class="form-control  @error('reject_message') is-invalid @enderror" rows="4" >
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

        }
        function clearVideo(){
            $("#video").val("");
        }
        $(function () {

            $("#area").select2();
            $("#city").select2();
            $("#user").select2();

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

