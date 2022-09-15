@extends('layouts.admin', ['crumbs' => [
    __('Members') => route('members.index'),
    __('Edit Members User Account') => route('members.edit', $user)]
, 'title' => __('Edit Members User Account')])
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

    <div class="card col-md-12 mx-auto">

        <form method="POST" action="{{route('members.update',$user->id)}}" enctype="multipart/form-data" accept-charset="UTF-8" class="form theme-form">
            <input name="_method" type="hidden" value="PUT"/>
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5>{{__('Account Information')}}</h5>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Full Name')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" placeholder="{{__('Full Name')}}" value="{{ $user->name }}" required>
                                @error('name')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{__('Email Address')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="{{__('Email Address')}}" value="{{ $user->email }}" >
                                @error('email')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Mobile')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="mobile" class="form-control  @error('mobile') is-invalid @enderror" id="mobile" placeholder="{{__('Mobile')}}" value="{{ $user->mobile }}" required size="8">
                                @error('mobile')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger"></span> {{__('Image Profile')}}</label>
                            <div class="col-sm-6">
                                <input name="image_profile" type="file" accept="image/*" class="form-control  @error('image_profile') is-invalid @enderror " value="{{old('image_profile')}}" >
                                <img />
                                @error('image_profile')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @else
                                    <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>supported
                                            file types: all image files (max size 500Kb)</small></div>
                                    @enderror

                            </div>
                            <div class="col-sm-3">
                                @if($user->image_profile!=null && $user->image_profile!="")
                                    <img    src="{{$user->image_profile}}" style="width:150px;height: 150px"/>
                                @else
                                    <label class="col-form-label text-danger">Not Uploaded</label>
                                @endif
                            </div>

                        </div>

{{--                        @if($user->type_usage=="company")--}}
{{--                                  <div class="form-group row">--}}
{{--                                    <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger"></span> {{__('Licence')}}</label>--}}
{{--                                    <div class="col-sm-6">--}}
{{--                                        <input name="licence" type="file" accept="image/*" class="form-control  @error('licence') is-invalid @enderror " value="{{old('licence')}}" >--}}
{{--                                        @error('licence')--}}
{{--                                        <div class="help-block text-danger">{{ $message }}</div>--}}
{{--                                        @else--}}
{{--                                            <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>supported--}}
{{--                                                    file types: all image files (max size 800Kb)</small></div>--}}
{{--                                            @enderror--}}
{{--                                    </div>--}}
{{--                                      <div class="col-sm-3">--}}
{{--                                          @if($user->licence!=null && $user->licence!="")--}}
{{--                                              <img    src="{{$user->licence}}" style="width:150px;height: 150px"/>--}}
{{--                                          @else--}}
{{--                                              <label class="col-form-label text-danger">Not Uploaded</label>--}}
{{--                                          @endif--}}
{{--                                      </div>--}}

{{--                                </div>--}}
{{--                        @endif--}}



{{--                        <div class="row">--}}
{{--                            <label for="mobile" class="col-sm-3 col-form-label"></label>--}}
{{--                            <div class="col">--}}
{{--                                <div class="checkbox">--}}
{{--                                    <input type="checkbox" @if($user->is_enable=1) checked  @endif  value="1" name="is_enable" id="is_enable">--}}
{{--                                    <label for="is_enable">Is Enable</label>--}}
{{--                                </div>--}}
{{--                                <div class="checkbox">--}}
{{--                                    <input type="checkbox" @if($user->verified==1) checked  @endif value="1" name="verified" id="verified">--}}
{{--                                    <label for="verified">Is Verify</label>--}}
{{--                                </div>--}}
{{--                                @if($user->type_usage=="company")--}}
{{--                                    <div class="checkbox">--}}
{{--                                        <input type="checkbox" @if($user->verified_office==1) checked  @endif value="1" name="verified_office" id="verified_office">--}}
{{--                                        <label for="verified_office">Is Verified Office</label>--}}
{{--                                    </div>--}}
{{--                                 @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}



                        @if($user->isCompany)
                            <!-- Company Settings -->
                            <hr>
                            @php
                                $socials = $user->socials()->get();
                            @endphp
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Company name')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_name" class="form-control  @error('company_name') is-invalid @enderror" id="company_name" placeholder="{{__('Company name')}}" value="{{ old('company_name', $user->company_name) }}">
                                    @error('company_name')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_phone" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Company phone')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_phone" class="form-control  @error('company_phone') is-invalid @enderror" id="company_phone" placeholder="{{__('Company phone')}}" value="{{ old('company_phone', $user->company_phone) }}">
                                    @error('company_phone')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="social_email" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Company email')}}</label>
                                <div class="col-sm-6">
                                    <input type="email" name="social_email" class="form-control  @error('social_email') is-invalid @enderror" id="social_email" placeholder="{{__('Company email')}}" value="{{ optional($socials->where('type', 'email')->first())->address }}">
                                    @error('social_email')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="instagram" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Instagram')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="instagram" class="form-control  @error('instagram') is-invalid @enderror" id="instagram" placeholder="{{__('Instagram')}}" value="{{ optional($socials->where('type', 'instagram')->first())->address }}">
                                    @error('instagram')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="twitter" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Twitter')}}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="twitter" class="form-control  @error('twitter') is-invalid @enderror" id="twitter" placeholder="{{__('Twitter')}}" value="{{ optional($socials->where('type', 'twitter')->first())->address }}">
                                    @error('twitter')
                                    <div class="help-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <hr>
                        <h5>Account Security</h5>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('New Password')}}</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="{{__('New Password')}}">
                                @error('password')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @else
                                <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>{{__('minimum 8 characters')}}</small></div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Confirm New Password')}}</label>
                            <div class="col-sm-6">
                                <input type="password" name="password_confirmation" class="form-control " placeholder="{{__('Confirm New Password')}}" id="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                <a @if($user->type_usage!="company")  href="{{route('members.individual')}}" @else   href="{{route('members.company')}}" @endif class="btn btn-light">{{__('Cancel')}}</a>
            </div>
        </form>
    </div>
@endsection
