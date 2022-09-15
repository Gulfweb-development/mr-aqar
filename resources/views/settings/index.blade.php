@extends('layouts.admin', ['crumbs' => [
    'Settings' => route('settings.index')]
, 'title' => __('List of Setting Key Values')])
@section('content')
    <!-- include libraries(jQuery, bootstrap) -->
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" onclick="addNewKey()">
                    <i class="fa fa-fw fa-plus"></i> Add Key
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('#')}}</th>
                            {{--                        <th scope="col">{{__('Key')}}</th>--}}
                            <th scope="col">{{__('Placeholder')}}</th>
                            <th style="width:50%" scope="col-sm-6">{{__('Value')}}</th>
                            {{--                        <th scope="col">{{__('Placeholder')}}</th>--}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @php $i=0; @endphp
                        @foreach($settings as $setting)
                            @if($setting->setting_key=="free_normal_advertising"||$setting->setting_key=="free_premium_advertising")
                                @continue
                            @endif
                            <tr id="{{$setting->id}}">
                                <td>{{++$i}}</td>
                                {{--                            @if($setting->setting_key=="free_normal_advertising"||$setting->setting_key=="free_premium_advertising")--}}
                                {{--                                <td>{{$setting->setting_placeholder}}</td>--}}
                                {{--                                @else--}}
                                {{--                                <td>{{$setting->setting_key}}</td>--}}
                                {{--                            @endif--}}
                                <td>{{($setting->setting_placeholder && $setting->setting_placeholder !== 'undefined') ? $setting->setting_placeholder  : $setting->setting_key }}</td>
                                <td  style="width:50%">
                                    @if($setting->setting_type=="text")
                                        <input type="text" class="form-control " id="input_{{$setting->id}}" value="{{$setting->setting_value}}" name="{{$setting->id}}_value">
                                    @elseif($setting->setting_type=="textarea")
                                        <textarea rows="5" style="padding:15px"  class="form-control " id="input_{{$setting->id}}" name="{{$setting->id}}_value"  >{{$setting->setting_value}}</textarea>
                                    @elseif($setting->setting_type=="textarea_editor")
                                        <textarea  style="padding:15px;height:400px;"  class="summernote" id="input_{{$setting->id}}" name="{{$setting->id}}_value"  >{!!$setting->setting_value!!}</textarea>
                                    @endif

                                </td>

                                {{--                            <td>--}}
                                {{--                                @if($setting->setting_key=="free_normal_advertising"||$setting->setting_key=="free_premium_advertising")--}}
                                {{--                                    <label>Is Enable</label>&nbsp;&nbsp;--}}
                                {{--                                    <input type="checkbox" class="form-group" name="check_input_{{$setting->id}}" @if($setting->is_enable) checked @endif >--}}
                                {{--                                    @else--}}
                                {{--                                    <input type="text" class="form-control " value="{{$setting->setting_placeholder}}" name="{{$setting->id}}_placeholder">--}}
                                {{--                                @endif--}}

                                {{--                            </td>--}}
                                <td>
                                    <button type="button" class="btn btn-secondary" name="{{$setting->id}}_submit"       @if($setting->setting_key=="free_normal_advertising"||$setting->setting_key=="free_premium_advertising") onclick="updateSetting('{{$setting->id}}',false)" @else  onclick="updateSetting('{{$setting->id}}',true)"@endif>Submit</button>
                                    {{--                                        <button type="button" class="btn btn-danger" name="{{$setting->id}}remove" onclick="removeSetting('{{$setting->id}}')">Remove</button>--}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <script>
        function removeSetting(key) {
            swal({
                title: "{{__('Are you sure you want to delete this item?')}}",
                text: "{{__('Be aware that deletion process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "/admin/settings/removeAjax",
                        method: "post",
                        data: {
                            _token: "{{csrf_token()}}",
                            key: key
                        }
                    })
                        .done(function (response) {
                            if (response.success) {
                                $("#"+key).remove();
                                swal(JSON.parse(response).message, "", "success");
                            } else {
                                swal(JSON.parse(response).message, "", "warning");
                            }
                        });
                }
            });
        }

        function updateSetting(key,state) {
            let form = new FormData();
            form.append("_token", "{{csrf_token()}}");
            form.append("key",key);
            // form.append("value", $("input[name="+key+"_value]").val());
            form.append("value", $("#input_"+key+"").val());
            if(state){
                form.append("placeholder", $("input[name="+key+"_placeholder]").val());
            }
            if(!state){
                form.append("is_enable", $("input[name=check_input_"+key).prop("checked"));
            }


            let settings = {
                "url": "/admin/settings/updateAjax",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax(settings).done(function (response) {
                swal(JSON.parse(response).message, "", "success");
            });
        }

        let tempKey = "", tempValue = "", tempPlaceholder = "", newKey = false;
        function createSetting() {
            let form = new FormData();
            form.append("_token", "{{csrf_token()}}");
            form.append("key", tempKey);
            form.append("value", tempValue);
            form.append("placeholder", tempPlaceholder);

            let settings = {
                "url": "/admin/settings/createAjax",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax(settings).done(function (response) {
                swal(JSON.parse(response).message, "", "success");
                newKey = false;
            });
        }

        function setNewKey(input) {
            tempKey = input.value;
        }

        function setNewValue(input) {
            tempValue = input.value;
        }

        function setNewPlaceholder(input) {
            tempPlaceholder = input.value;
        }

        function addNewKey() {
            if (!newKey) {
                newKey = true;
                let newChild = "<tr><td></td>" +
                    "<td><input type='text' name='new_setting_key' class='form-control' onkeyup='setNewKey(this)'></td>" +
                    "<td><input type='text' name='new_setting_value' class='form-control' onkeyup='setNewValue(this)'></td>" +
                    "<td><input type='text' name='new_setting_placeholder' class='form-control' onkeyup='setNewPlaceholder(this)'></td>" +
                    "<td><button type='button' class='btn btn-secondary' onclick='createSetting()'>Submit</button></td>" +
                    "</tr>";
                $("#table-body").append(newChild);
            }
        }
    </script>


@endsection
