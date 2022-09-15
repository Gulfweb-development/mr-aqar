@extends('layouts.admin', ['crumbs' => [
    __('Members') => route('members.index'),
    __('Verify User Account') => route('members.edit', $user)]
, 'title' => __('Verify User Account')])
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger col-sm-12">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-12 ">
        <div class="card">
            <form method="POST" action="{{route('members.setVerify')}}" enctype="multipart/form-data" accept-charset="UTF-8" class="form theme-form">
                <input name="user_id" type="hidden" value="{{$user->id}}"/>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Full Name')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->name }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Mobile')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->mobile }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Email')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->email }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Type')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->type_usage }}</label>
                                </div>
                            </div>
                            @if($user->type_usage=="company")
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label"> {{__('Company Name')}}</label>
                                    <div class="col-sm-3">
                                        <label class="col-form-label text-info">{{ $user->company_nam }}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label"> {{__('Is Verified Company')}}</label>
                                    <div class="col-sm-3">
                                        <label class="col-form-label  {{$user->verified_office==1?'text-success':'text-danger'}}">{{ $user->verified_office==1?"Yes":"No" }}</label>
                                    </div>
                                </div>


                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Package')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label  text-info">{{ isset($user->package)?$user->package->title_en:"----" }}</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Count Advertising')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label  text-info">{{ $user->advertising()->count() }}</label>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"> {{__('Join Date')}}</label>
                                <div class="col-sm-3">
                                    <label class="col-form-label text-info">{{ $user->created_at }}</label>
                                </div>
                            </div>


                            @if($user->image_profile!=null && $user->image_profile!="")
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label"> {{__('Profile Image')}}</label>
                                    <div class="col-sm-3">
                                        <img    src="{{$user->image_profile}}" style="width:150px;height: 150px"/>

                                    </div>
                                </div>
                            @endif


                        </div>
                        <div class="col-md-5"> <div class="row">
                                <div class="col">


                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <label for="mobile" class=" col-form-label"><span class="text-danger"></span> {{__('Licence/Civil')}}</label>
                                            <input name="licence" type="file" accept="image/*" class="form-control  @error('licence') is-invalid @enderror " value="{{old('licence')}}" >
                                            @error('licence')
                                            <div class="help-block text-danger">{{ $message }}</div>
                                            @else
                                                <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>supported
                                                        file types: all image files (max size 800Kb)</small></div>
                                                @enderror
                                        </div>
                                        <div class="col-sm-3">
                                            @if($user->licence!=null && $user->licence!="")
                                                <img    src="{{$user->licence}}" style="width:200px;height: 200px"/>
                                            @else
                                                <label class="col-form-label text-danger">Not Uploaded</label>
                                            @endif
                                        </div>
                                    </div>




                                    <div class="row">
                                        <label for="mobile" class="col-sm-3 col-form-label"></label>
                                        <div class="col">
                                            <div class="checkbox">
                                                <input type="checkbox" @if($user->verified==1) checked  @endif value="1" name="verified" id="verified">
                                                <label for="verified">Is Verify</label>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div></div>
                    </div>


                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    <a @if($user->type_usage!="company")  href="{{route('members.individual')}}" @else   href="{{route('members.company')}}" @endif class="btn btn-light">{{__('Cancel')}}</a>
                </div>
            </form>

        </div>

    </div>
@endsection
