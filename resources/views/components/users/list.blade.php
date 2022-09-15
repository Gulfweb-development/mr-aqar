
<div class="card-block row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Image')}}</th>
                    <th scope="col">{{__('Full Name')}}</th>
                    <th scope="col">{{__('Mobile')}}</th>
                    <th scope="col">{{__('Email Address')}}</th>
{{--                    <th scope="col">{{__('Is Verified')}}</th>--}}
{{--                    <th scope="col">{{__('Is Active')}}</th>--}}
                    <th scope="col">{{__('Count Advertising')}}</th>
                    <th scope="col">{{__('Type')}}</th>
                    <th scope="col">{{__('Package')}}</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php $row = 1; ?>
                @foreach($members as $member)
                    <tr>

                        <th scope="row">{{$row}}</th>
                        <td> <img style="width: 50px;height:50px"  @if($member->image_profile==null||$member->image_profile=="") src="{{asset('images/logo_new.png')}}" @else src="{{$member->image_profile}}" @endif>  </td>
                        <td>{{$member->name}}</td>
                        <td>{{$member->mobile}}</td>
                        <td>{{$member->email}}</td>
{{--                        <td> @if($member->type_usage!="company") {{$member->verified==1||$member->verified=="1"?"Yes":"No"}} @else {{$member->verified_office==1?"Yes":"No"}} @endif  </td>--}}
{{--                        <td>{{$member->is_enable==1?"Yes":"No"}}</td>--}}
                        <td>{{$member->advertising->count()}}</td>
                        <td>{{$member->type}}</td>
                        <td>{{$member->package?$member->package->title_en:"----"}}</td>
                        <td>
                            @php
                            if($member->type_usage=="individual"){
                            $adlinks = "admin/advertising-list/individual?user_id=".$member->id;
                            }else{
                            $adlinks = "admin/advertising-list/companies?user_id=".$member->id;
                            }
                            @endphp
                            @component('components.actionButtons', [
                                'routeEdit' => route('members.edit', $member->id),
                                'routeVerify' => route('members.verify', $member->id),
                                'routeView' => route('members.show', $member->id),
                                'routePayments' => route('payments.userPayment', $member->id),
                                'routeBalance' => route('members.balanceHistory', $member->id),
                                'routeChangePassword' => route('members.edit', $member->id),
                                'itemId' => $member->id,
                                'routeDelete' => route('members.destroy', $member->id),
                                'routeAdvertising'=> url($adlinks) // "/admin/advertising-list?user_id=".$member->id
                            ])
                            @endcomponent
                        </td>
                    </tr>
                    <?php $row++; ?>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $members->links() !!}
    </div>
</div>
