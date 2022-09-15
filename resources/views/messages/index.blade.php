@extends('layouts.admin', ['crumbs' => [
    'Messages' => route('messages.index')],
    'title' => __('Messages')
])
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{__('List of Messages')}}</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Email')}}</th>
                        <th scope="col">{{__('Phone number')}}</th>
                        <th scope="col">{{__('Date')}}</th>
                        <th scope="col">{{__('Message')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone_number}}</td>
                            <td>{{$item->created_at}}</td>
                            <td style="word-wrap:break-word; min-width:160px; max-width:160px;">{{$item->message}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                {{ $list->links()}}
            </div>
        </div>


    </div>

@endsection
@section('scripts')
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
@endsection
