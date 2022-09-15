@extends('layouts.admin', ['crumbs' => [
    'Invalid Keyword' => route('settings.invalidKeywords')],
    'title' => __('Manage Keywords')
])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('fancybox/source/jquery.fancybox.css')}}">
    <style>
        .select2 {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection


@section('content')
    <div class=" col-md-12">
        <div class="card">

            <form method="post" action="{{route('settings.updateInvalidKeywords')}}">
                <div class="card-body">

                    @csrf
                    <div class="row">
                        <div class="col">

                            <div class="form-group row" style="margin-top:20px">
                                <label for="mobile" class="col-sm-2 col-form-label"><span class="text-danger"></span> {{__('Invalid Keyword')}}</label>
                                <div class="col-sm-9">
                                    <select class="form-control"  style="width:100%;height:100%" name="invalid_keywords[]" id="invalid_keywords" multiple>
                                        @foreach($items as $item)
                                            <option selected>{{$item}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <span style="color:darkred">Enter New Keyword</span>
                                </div>
                            </div>
                            <br>
                            <hr>

                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    <a href="{{route('dashboard')}}" class="btn btn-light">{{__('Cancel')}}</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('fancybox/source/jquery.fancybox.js')}}" ></script>

    <script>
        $(function () {

               $("#invalid_keywords").select2({
                     tags: true
               });

        });
    </script>
@endsection

