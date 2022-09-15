<option value="">{{__('Select Area...')}}</option>
@foreach($areas as $area)
    <option value="{{$area->id}}">{{$area->name}}</option>
@endforeach
