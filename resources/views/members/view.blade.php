@extends('layouts.admin', ['crumbs' => [
    __('Members') => route('members.index'),
    __('View Information') => route('members.edit', $user)]
, 'title' => __('View Members Information')])
@section('content')
    <div class="card col-md-12 mx-auto">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4>{{__('Account Information')}}</h4>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Full Name')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $user->name }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Mobile')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $user->mobile }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Email')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $user->email }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Type')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $user->type_usage }}</label>
                            </div>
                        </div>

                        @if($user->type_usage=="company")
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Company Name')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->company_nam }}</label>
                                </div>
                            </div>
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-sm-1 col-form-label"> {{__('Is Verified Company')}}</label>--}}
{{--                                <div class="col-sm-3">--}}
{{--                                    <label class="col-form-label  {{$user->verified_office==1?'text-success':'text-danger'}}">{{ $user->verified_office==1?"Yes":"No" }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}


                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Package')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label  text-info">{{ isset($user->package)?$user->package->title_en:"----" }}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Count Advertising')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label  text-info">{{ $user->advertising()->count() }}</label>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> {{__('Join Date')}}</label>
                            <div class="col-sm-3">
                                <label class="col-form-label text-info">{{ $user->created_at }}</label>
                            </div>
                        </div>


                        @if($user->image_profile!=null && $user->image_profile!="")
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Image Licence')}}</label>
                                <div class="col-sm-3">
                                        <img    src="{{$user->image_profile}}" style="width:150px;height: 150px"/>

                                </div>
                            </div>
                        @endif


{{--                        @if($user->type_usage=="company")--}}
{{--                           <div class="form-group row">--}}
{{--                            <label for="name" class="col-sm-1 col-form-label"> {{__('Image Licence')}}</label>--}}
{{--                            <div class="col-sm-3">--}}
{{--                                @if($user->licence!=null && $user->licence!="")--}}
{{--                                   <img    src="{{$user->licence}}" style="width:150px;height: 150px"/>--}}
{{--                                    @else--}}
{{--                                    <label class="col-form-label text-danger">Not Uploaded</label>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @endif--}}


                        @if($user->isCompany)
                            @php
                                $socials = $user->socials()->get();
                            @endphp
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Company name')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->company_name }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Company phone')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->company_phone }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Company email')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ optional($socials->where('type', 'email')->first())->address }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Instagram')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ optional($socials->where('type', 'instagram')->first())->address }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-1 col-form-label"> {{__('Twitter')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ optional($socials->where('type', 'twitter')->first())->address }}</label>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        <div class="card-footer">
            <a href="{{route('members.index')}}" class="btn btn-light">{{__('Back To List')}}</a>
            <a href="{{route('members.edit', $user->id)}}" class="btn btn-info">{{__('Edit')}}</a>
        </div>
    </div>
@endsection
