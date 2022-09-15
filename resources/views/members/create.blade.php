@extends('layouts.admin', ['crumbs' => [
    __('Member Users') => route('members.index'),
    __('Create Account') => route('members.create')]
, 'title' => __('New Member User Account')])
@section('content')
    <div class="card col-md-12 mx-auto">
        <form method="post" action="{{route('members.store')}}" enctype="multipart/form-data" class="form theme-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5>{{__('Account Information')}}</h5>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Full Name')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" placeholder="{{__('Full Name')}}" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="email" class="col-sm-3 col-form-label">{{__('Email Address')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="{{__('Email Address')}}" value="{{ old('email') }}" >
                                @error('email')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Mobile')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="mobile" class="form-control  @error('mobile') is-invalid @enderror " id="mobile" placeholder="{{__('Mobile')}}" value="{{ old('mobile') }}" required size="8">
                                @error('mobile')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Type')}}</label>
                            <div class="col-sm-6">
                                <select id="type_usage" class="form-control " name="type_usage">
                                    <option  selected="selected" value="company">Company</option>
                                    <option  value="individual">Individual</option>
                                </select>
                                @error('type_usage')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger"></span> {{__('Packages')}}</label>
                            <div class="col-sm-6">

                                <select id="package_id" class="form-control " name="package_id">
                                    <option  selected="selected" value="">Select Package</option>
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->title_en}}</option>
                                    @endforeach
                                </select>

                                @error('packages')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger"></span> {{__('Image Profile')}}</label>
                            <div class="col-sm-6">
                                <input name="image_profile" type="file" accept="image/*" class="form-control  @error('image_profile') is-invalid @enderror " value="{{old('image_profile')}}" >
                                @error('image_profile')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @else
                                    <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>supported
                                            file types: all image files (max size 500Kb)</small></div>
                             @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger"></span> {{__('Licence')}}</label>
                            <div class="col-sm-6">
                                <input name="licence" type="file" accept="image/*" class="form-control  @error('licence') is-invalid @enderror " value="{{old('licence')}}" >
                                @error('licence')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @else
                                    <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>supported
                                            file types: all image files (max size 800Kb)</small></div>
                               @enderror
                            </div>
                        </div>



                        <div class="row">
                            <label for="mobile" class="col-sm-3 col-form-label"></label>
                            <div class="col">
                                <div class="checkbox">
                                    <input type="checkbox" checked name="is_enable" id="is_enable">
                                    <label for="is_enable">Is Enable</label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="verifed" id="verifed">
                                    <label for="verifed">Is Verify</label>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <h5>{{__('Account Security')}}</h5>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Password')}}</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="{{__('Password')}}" required>
                                @error('password')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @else
                                <div class="help-block text-info hint"><i class="fa fa-exclamation-circle"></i> <small>{{__('minimum 8 characters')}}</small></div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Confirm Password')}}</label>
                            <div class="col-sm-6">
                                <input type="password" name="password_confirmation" class="form-control " placeholder="{{__('Confirm Password')}}" id="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                <a href="{{route('members.index')}}" class="btn btn-light">{{__('Cancel')}}</a>
            </div>
        </form>
    </div>
@endsection
