<option value="">{{__('Select Branch...')}}</option>
@foreach($branches as $branch)
    <option value="{{$branch->id}}">{{$branch->name}}</option>
@endforeach
