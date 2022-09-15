

<div class="card-header">
    <div class="row">
        <div class="col-sm-4">
            <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> {{__('Add Area')}}</a>

        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-sm-12">

                <div class="form-group row">
                    <div class="col-sm-2">
                        <select class="form-control" id="city_id" name="city_id">
                            @foreach($cities as $city)
                                <option @if(isset(request()->cityId)) @if(request()->cityId==$city->id) selected  @endif  @endif value="{{$city->id}}">{{$city->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Type Area Name En..." required>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="name_ar" name="name_ar" placeholder="Type Area Name Ar..." required>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success" onclick="searchArea($('#city_id').val(),$('#name_en').val(),$('#name_ar').val());"><i class="fa fa-fw fa-search"></i> {{__('Search Area')}}</button>
                        <button type="button" class="btn btn-light" onclick="refreshPage();"><i class="fa fa-fw fa-close"></i> {{__('Cancel')}}</button>
                    </div>
                </div>

        </div>
    </div>
</div>
<div class="card-body">
    <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
            <th>{{__('City')}}</th>
            <th>{{__('NameEn')}}</th>
            <th>{{__('NameAr')}}</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="areas-list">
        @foreach($areas as $area)
            <tr>
                <td id="area-{{$area->id}}-city_title">{{optional($area->city)->name_en ?? ''}}</td>
                <td id="area-{{$area->id}}-name_en">{{$area->name_en}}</td>
                <td id="area-{{$area->id}}-name_ar">{{$area->name_ar}}</td>
                <td>
                    <i class="fa fa-fw fa-pencil text-success" data-toggle="modal" data-target="#editModal-area-{{$area->id}}" title="Edit" style="cursor: pointer;"></i>
                    {{--<button class="btn btn-xs btn-outline-success-2x" type="button" data-toggle="modal" data-target="#editModal-area-{{$area->id}}"><i class="fa fa-fw fa-pencil"></i> Edit</button>--}}
                    &nbsp;
                    <i class="fa fa-fw fa-remove text-danger" onclick="deleteArea('{{$area->id}}')" title="Delete" style="cursor: pointer;"></i>
                    {{--<button class="btn btn-xs btn-outline-danger-2x" type="button" onclick="deleteArea('{{$area->id}}')"><i class="fa fa-fw fa-remove"></i> Delete</button>--}}
                    <form id="destroy-form-area-{{$area->id}}" method="post" action="{{route('areas.destroy', $area->id)}}" style="display:none">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                </td>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal-area-{{$area->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('Edit Area')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <select required class="form-control" id="area-{{$area->id}}-city" name="city_id">
                                                @foreach($cities as $city)
                                                    <option id="opt-{{$area->id}}-city" title="{{$city->name_en}}"  @if($area->city_id==$city->id) selected  @endif  value="{{$city->id}}">{{$city->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="name_en" id="area-{{$area->id}}-new-name_en" value="{{$area->name_en}}" placeholder="Area new name...">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="name_ar" id="area-{{$area->id}}-new-name_ar" value="{{$area->name_ar}}" placeholder="Area new name...">
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="editArea('{{$area->id}}')">{{__('Update')}}</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>

            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    {!! $areas->links() !!}

    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Add Area')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="{{route('areas.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <select required class="form-control" id="add_city_id" name="city_id">
                                    @foreach($cities as $city)
                                        <option @if(isset(request()->cityId)) @if(request()->cityId==$city->id) selected  @endif  @endif value="{{$city->id}}">{{$city->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input required type="text" class="form-control" name="name_en"   placeholder="Area new name...">
                            </div>
                            <div class="col-sm-4">
                                <input required type="text" class="form-control" name="name_ar"   placeholder="Area new name...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >{{__('Add')}}</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>

                </form>


            </div>
        </div>
    </div>

</div>

<script>
    function editArea(id) {
        let city = $("#area-"+id+"-city").val();
        let newName = $("#area-"+id+"-new-name_en").val();
        let newNamear = $("#area-"+id+"-new-name_ar").val();
        if (!newName) {
            swal({"title": "Enter New Name", "icon": "warning"});
        } else {
            $.ajax({
                url: "{{route('areas.update')}}",
                method: "post",
                data: {
                    _token: "{{csrf_token()}}",
                    area: id,
                    name_en: newName,
                    name_ar:newNamear,
                    city_id:city,
                }
            }).done(function (response) {
                window.location.href="/admin/area";
                    if (response.success) {
                        $("#area-"+id+"-name_en").html(newName);
                        $("#area-"+id+"-name_ar").html(newNamear);
                        $("#area-"+id+"-city_title").html(newNamear);

                        $("#editModal-area-"+id).modal("hide");
                    } else {
                        swal({"title": "Unable to update!", "icon": "error"});
                    }
                });
        }
    }
    function deleteArea(id) {
        swal({
            title: "{{__('Are you sure you want to delete this item?')}}",
            text: "{{__('Be aware that deletion process is non-returnable')}}",
            icon: "warning",
            buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('destroy-form-area-'+id).submit();
            }
        });
    }
    function searchArea(cityId,nameEn,nameAr) {
        var page="{{request()->page}}";
        var path="/admin/area?cityId="+cityId+"&name_en="+nameEn+"&name_ar="+nameAr;
        if(page!=null||page!==undefined){
            path+="&page="+page;
        }
        window.location.href=path;
    }
    function refreshPage() {
        var path="/admin/area";
        window.location.href=path;
    }

</script>
