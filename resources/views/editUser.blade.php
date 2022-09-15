@extends('layouts.admin', ['crumbs' => []])
@section('content')
    <div class="card col-md-8 mx-auto">
        <div class="card-header">
            <h5>{{__('Edit Profile')}}</h5>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::model($user, array('route' => array('updateProfile', $user), 'method' => 'PUT', 'class' => 'form theme-form')) !!}
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5>{{__('User Information')}}</h5>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Full Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control btn-pill @error('name') is-invalid @enderror" id="name" placeholder="{{__('Full Name')}}" value="{{ $user->name }}" required>
                            @error('name')
                            <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">{{__('Email Address')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="email" class="form-control btn-pill @error('email') is-invalid @enderror" id="email" placeholder="{{__('Email Address')}}" value="{{ $user->email }}" >
                            @error('email')
                            <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3 col-form-label"><span class="text-danger">*</span> Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" name="mobile" class="form-control btn-pill @error('mobile') is-invalid @enderror" id="mobile" placeholder="{{__('Mobile')}}" value="{{ $user->mobile }}" required size="8">
                            @error('mobile')
                            <div class="help-block text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    @component('components.password-component')@endcomponent
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            <a href="{{route('dashboard')}}" class="btn btn-light">{{__('Cancel')}}</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
