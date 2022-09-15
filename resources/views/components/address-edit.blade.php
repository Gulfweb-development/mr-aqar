
<hr>
<h5>{{__('Pickup Address')}}</h5>
<div class="form-group row">
    <label for="country_id" class="col-sm-3 col-form-label"><label class="text-danger" style="font-size: 16px;">*</label> {{__('Country')}}</label>
    <div class="col-sm-9">
        {!! Form::select('country_id', $countries, $data->country_id, array("class" => "form-control btn-pill", "id" => "country_id", "placeholder" => __('Select Country...'), "value" => $data->country_id, "required" => "required", "onchange" => "changeCountry(this.value)")) !!}
        @error('country_id')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="area_id" class="col-sm-3 col-form-label"><label class="text-danger" style="font-size: 16px;">*</label> {{__('Area')}}</label>
    <div class="col-sm-9">
        {!! Form::select('area_id', $areas, $data->area_id, array("class" => "form-control btn-pill", "id" => "area_id", "placeholder" => __('Select Area...'), "value" => $data->area_id, "required" => "required")) !!}
        @error('area_id')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="block" class="col-sm-3 col-form-label"><label class="text-danger" style="font-size: 16px;">*</label> {{__('Block')}}</label>
    <div class="col-sm-9">
        <input type="text" name="block" class="form-control btn-pill @error('block') is-invalid @enderror" id="block" value="{{$data->block}}" required>
        @error('block')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="street" class="col-sm-3 col-form-label"><label class="text-danger" style="font-size: 16px;">*</label> {{__('Street')}}</label>
    <div class="col-sm-9">
        <input type="text" name="street" class="form-control btn-pill @error('street') is-invalid @enderror" id="street" value="{{$data->street}}" required>
        @error('street')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="avenue" class="col-sm-3 col-form-label">{{__('Avenue')}}</label>
    <div class="col-sm-9">
        <input type="text" name="avenue" class="form-control btn-pill @error('avenue') is-invalid @enderror" id="avenue" value="{{$data->avenue}}" >
        @error('avenue')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="building_number" class="col-sm-3 col-form-label"><label class="text-danger" style="font-size: 16px;">*</label> {{__('Building No.')}}</label>
    <div class="col-sm-9">
        <input type="text" name="building_number" class="form-control btn-pill @error('building_number') is-invalid @enderror" id="building_number" value="{{$data->building_number }}" >
        @error('building_number')
        <div class="help-block text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="place_type" class="col-sm-3 col-form-label">{{__('Place Type')}}</label>
    <div class="col-sm-9">
        {!! Form::select('place_type', \CargoLogisticsModels\Setting::where('setting_key', 'LIKE', 'place_type')->pluck('setting_value', 'setting_value')->toArray(), $data->place_type, array('id' => 'place_type', 'class' => 'form-control btn-pill', 'placeholder' => __('Select from list...'))) !!}
    </div>
</div>


<script>
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
