@extends('layouts.admin', ['crumbs' => [
    'Payments' => route('payments.index')],
    'title' => __('Payments')
])
@section('content')
    <div class="col-md-12">
     <div class="card">
         <div class="card-header">
             <h5>{{__('List of Payments')}}</h5>

             <br>

             <form method="get" action="/admin/payments">
                     <div class="row">
                         <div class="col-sm-12">
                                 <div class="form-group row">
                                     <div class="col-sm-4">
                                         <label for="fromDate" class=" col-form-label">{{__('Start Date')}}</label>
                                         <input type="date" @if(isset(request()->fromDate)) value="{{request()->fromDate}}"  @endif  name="fromDate" id="from-date" class="form-control" />
                                     </div>
                                     <div class="col-sm-4">
                                         <label for="fromDate" class=" col-form-label">{{__('Start Date')}}</label>
                                         <input type="date" @if(isset(request()->toDate)) value="{{request()->toDate}}" @endif placeholder="{{__('End Date')}}" name="toDate" id="to-date" class="form-control" />
                                     </div>
                                     <div class="col-sm-4">
                                         <label for="fromDate" class=" col-form-label">{{__('Status')}}</label>
                                         <select  name="status" class="form-control">
                                             <option  value="all">all</option>
                                             <option @if(isset(request()->status) && request()->status=="completed" ) selected  @endif value="completed">Completed</option>
                                             <option @if(isset(request()->status) && request()->status=="failed" ) selected  @endif value="failed">Failed</option>
                                             <option @if(isset(request()->status) && request()->status=="new" ) selected  @endif value="new">new</option>
                                         </select>
                                     </div>
                                     <div class="col-sm-3" style="margin-top: 35px;margin-left:15px">
                                         <button type="submit"  class="btn btn-secondary"><i class="fa fa-fw fa-search"></i> {{__('Filter')}}</button>
                                         <button type="button" class="btn btn-light" onclick="window.location.href='/admin/payments'"><i class="fa fa-fw fa-close"></i> {{__('Cancel')}}</button>
                                     </div>

                                 </div>
                         </div>
                     </div>
                </form>

         </div>
         <div class="card-body">
             <table class="table table-striped table-hover">
                 <thead class="thead-light">
                 <tr>
                     <th>#</th>
                     <th>Payment ID</th>
                     <th>Trans ID</th>
                     <th>Track ID</th>
                     <th>RefId</th>
                     <th>User</th>
                     <th>Package</th>
                     <th>Price</th>
{{--                     <th>Count</th>--}}
{{--                     <th>Sum</th>--}}
                     <th>Status</th>
                     <th>Type</th>
                     <!--<th>Accept</th>-->

                     <th>Actions</th>
                 </tr>
                 </thead>
                 <tbody id="countries-list">
                 @php $i=0; @endphp
                 @foreach($list as $item)
                     <tr>

                         <td>{{++$i}}</td>
                         <td>{{optional($item->order)->payment_id??'----'}}</td>
                         <td>{{optional($item->order)->tranid??"----"}}</td>
                         <td>{{optional($item->order)->trackid??'----'}}</td>
                         <td>{{$item->ref_id??"----"}}</td>

                         @if($item->user)
                             <td><a target="_blank" href="{{route("members.show",optional($item->user)->id)}}">{{optional($item->user)->name??'----'}}</a></td>
                               @else
                             <td>----</td>
                         @endif

                         <td>{{optional($item->package)->title_en??"----"}}</td>
                         <td>{{$item->price}}</td>
{{--                         <td>{{optional($item->packageHistory)->count}}</td>--}}
{{--                         <td>{{floatval(optional($item->packageHistory)->price)*intval(optional($item->packageHistory)->count)}}</td>--}}
                         <td>@if($item->status=='completed')<font color="#009900">{{$item->status}}</font>@else<font color="#ff0000">{{$item->status}}</font>@endif</td>
                         <td>{{$item->payment_type}}</td>
                         <!--<td>{{optional($item->packageHistory)->accept_by_admin==0?"No":"Yes"}}</td>-->

                         <td>
                             <button type="button" class="btn btn-outline-secondary-2x dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}</button>
                             <div class="dropdown-menu">
                                 <a class="dropdown-item text-info" href="{{route('payments.showDetail',['id'=>$item->id])}}"  ><i class="fa fa-fw fa-check"></i> {{__('View & Print')}}</a>

                             @if($item->payment_type=="Cash" && optional($item->packageHistory)->accept_by_admin==0)
                                     <a class="dropdown-item text-success" href="#" onclick='event.preventDefault(); accept({{$item->id}});' ><i class="fa fa-fw fa-check"></i> {{__('Accept')}}</a>
                                     <form id="accept-form-{{$item->id}}" method="post" action="{{'paymenthistory/accept/' . optional($item->packageHistory)->id }}" style="display:none">
                                         @csrf
                                     </form>
                                 @endif
                             </div>
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
             </table>
         </div>
     </div>
    </div>
@endsection
@section('scripts')
    <script>
        function accept(id) {
            swal({
                title: "{{__('Are you sure you want to accept item?')}}",
                text: "{{__('Be aware that accept process is non-returnable')}}",
                icon: "warning",
                buttons: ["{{__('Cancel')}}", "{{__('Accept')}}"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('accept-form-'+id).submit();
                }
            });
        }

    </script>
@endsection