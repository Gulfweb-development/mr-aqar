<div class="card-header">
    <form method="post" action="{{route('city.store')}}">
        @csrf
        <div class="form-group row">
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name_en" placeholder="Type City Name En..." required>
            </div> <div class="col-sm-3">
                <input type="text" class="form-control" name="name_ar" placeholder="Type City Name Ar..." required>
            </div>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> {{__('Add City')}}</button>
            </div>
        </div>
    </form>
</div>
<div class="card-body">
    <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
            <th>{{__('NameEn')}}</th>
            <th>{{__('NameAr')}}</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="countries-list">
        @foreach($cities as $city)
            <tr>
                <td id="{{$city->id}}-name_en">{{$city->name_en}}</td>
                <td id="{{$city->id}}-name_ar">{{$city->name_ar}}</td>
                <td>
                    <i class="fa fa-fw fa-pencil text-success" data-toggle="modal" data-target="#editModal-{{$city->id}}" title="Edit" style="cursor: pointer;"></i>
                    {{--<button class="btn btn-xs btn-outline-success-2x" type="button" data-toggle="modal" data-target="#editModal-{{$country->id}}"><i class="fa fa-fw fa-pencil"></i> Edit</button>--}}
                    &nbsp;
                    <i class="fa fa-fw fa-remove text-danger" title="Delete" onclick="deleteCountry('{{$city->id}}')" style="cursor: pointer;"></i>
                    {{--<button class="btn btn-xs btn-outline-danger-2x" type="button" onclick="deleteCountry('{{$country->id}}')"><i class="fa fa-fw fa-remove"></i> Delete</button>--}}
                    <form id="destroy-form-{{$city->id}}" method="post" action="{{route('city.destroy', $city->id)}}" style="display:none">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                </td>

                    <!-- Edit Modal -->
                    <div class="modal" id="editModal-{{$city->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('Edit City')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="country" id="{{$city->id}}-new-name_en" value="{{$city->name_en}}" placeholder="Country new name..." required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="country" id="{{$city->id}}-new-name_ar" value="{{$city->name_ar}}" placeholder="Country new name...">
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="button" class="btn btn-secondary" onclick="editCountry('{{$city->id}}')">{{__('Confirm')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
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
</div>
<script>
    function editCountry(id) {
        let newName = $("#"+id+"-new-name_en").val();
        let newNamear = $("#"+id+"-new-name_ar").val();

        if (!newName) {
            swal({"title": "Enter New Name", "icon": "warning"});
        } else {
            $.ajax({
                url: "{{route('city.update')}}",
                method: "post",
                data: {
                    _token: "{{csrf_token()}}",
                    id: id,
                    name_en: newName,
                    name_ar:newNamear
                }
            })
                .done(function (response) {
                    if (response.success) {
                        $("#"+id+"-name_en").html(newName);
                        $("#editModal-"+id).modal("hide");
                    } else {
                        swal({"title": "Unable to update!", "icon": "error"});
                    }
                });
        }
    }

    function deleteCountry(id) {
        swal({
            title: "{{__('Are you sure you want to delete this item?')}}",
            text: "{{__('Be aware that deletion process is non-returnable')}}",
            icon: "warning",
            buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('destroy-form-'+id).submit();
            }
        });
    }
</script>
