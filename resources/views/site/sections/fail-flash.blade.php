@error('fail')
<div class="alert alert-danger">
    <strong>{{__('un_success_title')}}!</strong> {{$message}} !
</div>
@enderror
@if((session('controller-success')))
    <div class="alert alert-success">
        <strong>{{__('success_title')}}!</strong> {{session('controller-success')}} !
    </div>
@endif
