<hr>
<h5>Account Security</h5>
<div class="form-group row">
    <label for="password" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Password')}}</label>
    <div class="col-sm-9">
        <input type="password" name="password" class="form-control btn-pill @error('password') is-invalid @enderror" id="password" placeholder="{{__('Password')}}" required>
        @error('password')
        <div class="help-block text-danger">{{ $message }}</div>
        @else
            <div class="help-block text-info" style="margin-left: 10px;"><i class="fa fa-exclamation-circle"></i> <small>{{__('minimum 8 characters')}}</small></div>
            @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password_confirmation" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Confirm Password')}}</label>
    <div class="col-sm-9">
        <input type="password" name="password_confirmation" class="form-control btn-pill" placeholder="{{__('Confirm Password')}}" id="password_confirmation" required>
    </div>
</div>
