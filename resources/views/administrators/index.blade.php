@extends('layouts.admin', ['crumbs' => [
    __('Admin Users') => route('administrators.index')]
,'title' => __('List of Admin Users')])
@section('content')
    <div class="col-sm-12">
        <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-4">
                            <a class="btn btn-primary" href="{{route('administrators.create')}}">
                                <i class="fa fa-fw fa-plus"></i>
                                {{__('Create New Admin')}}
                            </a>
                        </div>

                        <div class="col-sm-3">
                            <input type="text" name="search_table" class="form-control  " id="search_table" placeholder="Search Name Or Mobile" value="{{request('search')}}" required="" autocomplete="off">

                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" onclick="search();">search</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('Full Name')}}</th>
                                <th scope="col">{{__('Email Address')}}</th>
                                <th scope="col">{{__('Mobile')}}</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $row = 1; ?>
                            @foreach($administrators as $administrator)
                                <tr>
                                    <th scope="row">{{$row}}</th>
                                    <td>{{$administrator->name}}</td>
                                    <td>{{$administrator->email}}</td>
                                    <td>{{$administrator->mobile}}</td>
                                    <td>
                                        @component('components.actionButtons', [
                                            'routeEdit' => route('administrators.edit', $administrator->id),
                                            'itemId' => $administrator->id,
                                            'routeDelete' => route('administrators.destroy', $administrator->id),
                                        ])
                                        @endcomponent
                                    </td>
                                </tr>
                                <?php $row++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

    <script>
        function search() {
            var name=$("#search_table").val();
            window.location.href = "/admin/administrators/?search="+name;

        }
    </script>
@endsection
