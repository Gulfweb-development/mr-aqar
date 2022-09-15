@extends('layouts.admin', ['crumbs' => [
    __('Admin Users') => route('administrators.index'),
    __('Create Account') => route('administrators.create')]
, 'title' => __('New Admin User Account')])
@section('content')
    <div class="card col-md-12 mx-auto">
        <form method="post" action="{{route('administrators.store')}}" class="form theme-form">
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
                        <div class="form-group row">
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
                                <input type="text" name="mobile" class="form-control  @error('mobile') is-invalid @enderror" id="mobile" placeholder="{{__('Mobile')}}" value="{{ old('mobile') }}" required size="8">
                                @error('mobile')
                                <div class="help-block text-danger">{{ $message }}</div>
                                @enderror
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
                <a href="{{route('administrators.index')}}" class="btn btn-light">{{__('Cancel')}}</a>
            </div>
        </form>
    </div>
@endsection
