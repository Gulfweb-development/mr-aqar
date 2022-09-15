<hr>
<h5>{{$title}}</h5>
<div class="form-group row">
    <label for="country_id" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Country')}}</label>
    <div class="col-sm-9">
        {!! Form::select('country_id', $countries, null, array("class" => "form-control btn-pill", "id" => "country_id", "placeholder" => __('Select Country...'), "value" => old('country_id'), "required" => "required", "onchange" => "changeCountry(this.value)")) !!}
    </div>
</div>

<div class="form-group row">
    <label for="area_id" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Area')}}</label>
    <div class="col-sm-9">
        <select name="area_id" class="form-control btn-pill @error('area_id') is-invalid @enderror" id="area_id" value="{{old('area_id')}}" required><option value="" selected>Select Area...</option></select>
        @error('area_id')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="block" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Block')}}</label>
    <div class="col-sm-9">
        <input type="text" name="block" class="form-control btn-pill @error('block') is-invalid @enderror" id="block" placeholder="{{__('Block')}}" value="{{ old('block') }}" required>
        @error('block')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="street" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Street')}}</label>
    <div class="col-sm-9">
        <input type="text" name="street" class="form-control btn-pill @error('street') is-invalid @enderror" id="street" placeholder="{{__('Street')}}" value="{{ old('street') }}" required>
        @error('street')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="avenue" class="col-sm-3 col-form-label">{{__('Avenue')}}</label>
    <div class="col-sm-9">
        <input type="text" name="avenue" class="form-control btn-pill @error('avenue') is-invalid @enderror" id="avenue" placeholder="{{__('Avenue')}}" value="{{ old('avenue') }}" >
        @error('avenue')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="building_number" class="col-sm-3 col-form-label"><span class="text-danger">*</span> {{__('Building No.')}}</label>
    <div class="col-sm-9">
        <input type="text" name="building_number" class="form-control btn-pill @error('building_number') is-invalid @enderror" id="building_number" placeholder="{{__('Building No.')}}" value="{{ old('building_number') }}" >
        @error('building_number')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="place_type" class="col-sm-3 col-form-label">{{__('Place Type')}}</label>
    <div class="col-sm-9">
        {!! Form::select('place_type', \CargoLogisticsModels\Setting::where('setting_key', 'LIKE', 'place_type')->pluck('setting_value', 'setting_value')->toArray(), null, array('id' => 'place_type', 'class' => 'form-control btn-pill', 'placeholder' => __('Select from list...'))) !!}
    </div>
</div>

<div class="form-group row">
    <label for="floor" class="col-sm-3 col-form-label">{{__('Floor')}}</label>
    <div class="col-sm-9">
        <input type="text" name="floor" class="form-control btn-pill @error('floor') is-invalid @enderror" id="floor" placeholder="{{__('Floor')}}" value="{{ old('floor') }}" >
        @error('floor')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="unit_number" class="col-sm-3 col-form-label">{{__('Unit Number')}}</label>
    <div class="col-sm-9">
        <input type="text" name="unit_number" class="form-control btn-pill @error('unit_number') is-invalid @enderror" id="unit_number" placeholder="{{__('Unit Number')}}" value="{{ old('unit_number') }}" >
        @error('unit_number')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>


<script>
    $(document).ready(function() {
        let country = $("#country_id").val();
        if (country) {
            changeCountry(country);
        }
    });

    function changeCountry(input) {
        $.ajax({
            url: "/getAreas/"+input,
            method: "get",
            data: {
                country: input
            }
        })
            .done(function (response) {
                $("#area_id").html(response);
            });
    }
</script>
