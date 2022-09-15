@extends('layouts.admin', ['crumbs' => [], 'title' => __('List of words and phrases')])
@section('content')
    <div class="card col-md-12">
        <form method="post" action="#" class="form theme-form">
            <div class="card-body">
                <table class="table" id="translations-table">
                    <thead>
                    <tr>
                        <th class="col-sm-5">key</th>
                        <th class="col-sm-5">Arabic</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lang as $key => $value)
                        <tr>
                            <td class="col-sm-5">{{$key}}</td>
                            <td class="col-sm-5"><input name="{{$key}}" type="text" class="form-control btn-pill data" value="{{$value}}"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" onclick="saveLang()" class="btn btn-primary">Submit</button>
                <a href="{{route('translations')}}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#translations-table').dataTable( { "pageLength": 500 } );
        });

        function saveLang() {
            event.preventDefault();
            let result = {};

            $(".data").each(function(){
                result[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                url: '{{route('updateLanguage')}}',
                type: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    result,
                }
            }).done(function (response) {
                window.location.href = response;
            });
        }
    </script>

    <!-- Datatable js -->
    <script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/datatables/datatable.custom.js')}}"></script>
@endsection
