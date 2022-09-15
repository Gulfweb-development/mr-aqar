<button type="button" class="btn btn-outline-secondary-2x dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('Actions')}}</button>
<div class="dropdown-menu">
    @if(isset($routeEdit))<a class="dropdown-item text-primary" href="{{ $routeEdit }}"><i class="fa fa-fw fa-edit"></i> {{__('Edit')}}</a>@endif
{{--    @if(isset($routeVerify))<a class="dropdown-item text-primary" href="{{ $routeVerify }}"><i class="fa fa-fw fa-check"></i> {{__('Verify')}}</a>@endif--}}
    @if(isset($routeView))<a class="dropdown-item text-dark" href="{{ $routeView }}"><i class="fa fa-fw fa-share"></i> {{__('View')}}</a>@endif
    @if(isset($routeChangePassword))<a class="dropdown-item text-danger" href="{{ $routeChangePassword }}"><i class="fa fa-fw fa-key"></i> {{__('Change Password')}}</a>@endif
    @if(isset($routeJobDetails))<a class="dropdown-item text-success" href="{{ $routeJobDetails }}"><i class="fa fa-fw fa-list-alt"></i> {{__('Job Details')}}</a>@endif
    @if(isset($routePayments))<a class="dropdown-item text-info" href="{{ $routePayments }}"><i class="fa fa-fw fa-paypal"></i> {{__('Payments')}}</a>@endif
    @if(isset($routeBalance))<a class="dropdown-item text-dark" href="{{ $routeBalance }}"><i class="fa fa-fw fa-credit-card"></i> {{__('Balance History')}}</a>@endif

    @if(isset($routeAdvertising))<a class="dropdown-item text-success"  href="{{$routeAdvertising }}"><i class="fa fa-fw fa-list"></i> {{__('Show Advertising')}}</a>@endif
    @if(isset($routeLogs))<a class="dropdown-item text-success" href="{{ $routeLogs }}"><i class="fa fa-fw fa-list"></i> {{__('Show Log')}}</a>@endif
    @if(isset($routeDelete))
        <a class="dropdown-item text-danger" href="#" onclick='event.preventDefault(); destroy({{$itemId}});' ><i class="fa fa-fw fa-trash"></i> {{__('Delete')}}</a>
        <form id="destroy-form-{{$itemId}}" method="post" action="{{$routeDelete}}" style="display:none">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        </form>
    @endif
</div>

<script>
    function destroy(itemId) {
        swal({
            title: "{{__('Are you sure you want to delete this item?')}}",
            text: "{{__('Be aware that deletion process is non-returnable')}}",
            icon: "warning",
            buttons: ["{{__('Cancel')}}", "{{__('Delete')}}"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('destroy-form-'+itemId).submit();
            }
        });
    }
</script>
