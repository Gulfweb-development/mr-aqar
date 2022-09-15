<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Title')}}</th>
            <th scope="col">{{__('User')}}</th>
            <th scope="col" width="50">{{__('Type')}}</th>
            <th scope="col" width="200">{{__('Location')}}</th>
            <th scope="col" width="50">{{__('Price')}}</th>
            <th scope="col" width="50">{{__('Status')}}</th>
            <th scope="col" width="160">{{__('Date')}}</th>
            <th scope="col" width="50"></th>
        </tr>
        </thead>
        <tbody>
        @php $i=0; @endphp
        @foreach($advertising as $item)
            <tr @if($item->advertising_type=="premium") class="premium" @elseif(isset($item->expire_at)&& $item->expire_at<=date("Y-m-d"))  class="expire"   @endif>
                <td>{{++$i}}</td>

                <td>{{$item->title_en}}<br>{{$item->title_ar}}</td>
                <td>
                <strong>{{__('Name')}}:</strong><a target="_blank" href="{{route("members.show",optional($item->user)->id)}}">{{optional($item->user)->name??'----'}}</a>
                @if(optional($item->user)->mobile)<br /><strong>{{__('Phone')}}:</strong>{{optional($item->user)->mobile}}@endif
                @if(optional($item->user)->type)<br /><strong>{{__('Type')}}:</strong>{{optional($item->user)->type}}@endif
                </td>
                <td @if($item->advertising_type=="premium") style="color: #204ba7 !important;font-weight: bold" @endif>{{$item->advertising_type}}</td>
                <td>
                <strong>{{__('Venue Type')}}:</strong> {{$item->venue_type}}
                <br />
                <strong>{{__('purpose')}}:</strong> {{$item->purpose}}
                <br />
                <strong>City:</strong> {{optional($item->city)->name_en??'--'}}
                <br />
                <strong>Area:</strong> {{optional($item->area)->name_en??'----'}}
                </td>

                <td>{{$item->price}}</td>
                <td  @if($item->status=="accepted") class="text-success" @else class="text-danger" @endif>@if($item->status=='accepted') Published @else UnPublished @endif</td>
                <td>
                <strong>Posted:</strong> <small>{{$item->getOriginal('created_at')}}</small>
                @if(isset($item->expire_at))<br /><strong>Expired:</strong> <small>{{Carbon\Carbon::parse($item->expire_at)->diffForHumans()}}</small> @endif
                </td>

                <td>

                    <button type="button" class="btn btn-outline-secondary-2x dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}</button>
                    <div class="dropdown-menu">
                        {{--                                            @if(isset($routeEdit))<a class="dropdown-item text-primary" href="{{ $routeEdit }}"><i class="fa fa-fw fa-edit"></i> {{__('Edit')}}</a>@endif--}}

                        <a class="dropdown-item text-info" href="{{route("advertising.details",$item->id)}}" ><i class="fa fa-fw fa-pencil text-success" data-toggle="modal" data-target="#edit_modal"  style="cursor: pointer;"></i> {{__('Details')}}</a>
                        <a class="dropdown-item text-info" href="{{route("advertising.view",$item->id)}}" ><i class="fa fa-fw fa-search-plus text-info" data-toggle="modal" data-target="#edit_modal"  style="cursor: pointer;"></i> {{__('View')}}</a>





                        <a class="dropdown-item text-danger" href="#" onclick='event.preventDefault(); destroy({{$item->id}});' ><i class="fa fa-fw fa-trash"></i> {{__('Delete')}}</a>

                        @if($item->status=="new")
                              <a class="dropdown-item text-success" href="#" onclick='event.preventDefault(); accept({{$item->id}});' ><i class="fa fa-fw fa-check"></i> {{__('Accept')}}</a>
                        @endif



                        <form id="destroy-form-{{$item->id}}" method="post" action="{{route('advertising.destroy',$item->id)}}" style="display:none">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        <form id="accept-form-{{$item->id}}" method="post" action="{{route('advertising.accept',$item->id)}}" style="display:none">
                            @csrf
                        </form>
                    </div>

                    <script>

                    </script>

                </td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>
<br>

{!! $advertising->appends(request()->except('page'))->links()!!}
