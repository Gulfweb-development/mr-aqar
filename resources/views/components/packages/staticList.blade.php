<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{__('List of Packages')}}</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th>{{__('Title En')}}</th>
                        <th>{{__('Title Ar')}}</th>
                        <th>{{__('Price')}}</th>
                        <th>{{__('Count Day')}}</th>
                        <th>{{__('Count Show Day')}}</th>
                        <th>{{__('Count Advertising')}}</th>
                        <th>{{__('Count Premium')}}</th>
                        <th>{{__('Is Premium')}}</th>
                        <th>{{__('Is Active')}}</th>
                        <th>{{__('Actions')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="countries-list">
                    @foreach($packages as $package)
                        @if($package->user_type==$type)
                            <tr>
                                <td >{{$package->title_en}}</td>
                                <td >{{$package->title_ar}}</td>
                                <td >{{$package->price}}</td>
                                <td >{{$package->count_day}}</td>
                                <td >{{$package->count_show_day}}</td>
                                <td >{{$package->count_advertising}}</td>
                                <td >{{$package->count_premium}}</td>
                                <td >{{$package->is_premium==1?"Yes":"No"}}</td>
                                <td >{{$package->is_enable==1?"Yes":"No"}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary-2x dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}</button>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item text-info" href="{{route("staticPackages.edit",$package->id)}}" ><i class="fa fa-fw fa-pencil text-success" data-toggle="modal" data-target="#edit_modal"  style="cursor: pointer;"></i> {{__('Edit')}}</a>
{{--                                        <a class="dropdown-item text-danger" href="#" onclick='event.preventDefault(); destroyByForm({{$package->id}});' ><i class="fa fa-fw fa-trash"></i> {{__('Delete')}}</a>--}}
                                        <form id="destroy-form-{{$package->id}}" method="post" action="{{route('staticPackages.destroy',$package->id)}}" style="display:none">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
