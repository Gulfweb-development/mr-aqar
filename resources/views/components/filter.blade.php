<div style="margin: 10px 0;">
    <div class="float-left form-group row">
        {{--<label for="filter" class="col-sm-4 col-form-label">Filter: </label>--}}
        <div class="col-sm-12">
            <select name="filter" id="filter" class="form-control" style="margin-left: 30px;" onchange="refreshTable(this.value);">
                <option value="all">{{__("All $type")}}</option>
                <option value="unapproved">{{__('Unapproved')}}</option>
                <option value="approved">{{__('Approved')}}</option>
                <option value="inactive">{{__('Inactive')}}</option>
            </select>
        </div>

    </div>

    @if($type=="Driver" && auth()->user()->user_type == 'admin')
        <div class="float-left form-group row " style="margin-left: 45px" >
            <div class="col-sm-12">
                <select name="filter_vendor" id="filter_vendor" class="form-control"  onchange="refreshTable($('#filter').val());">
                    <option value="all">{{__("All Vendor")}}</option>
                    @if(isset($vendors))
                         @foreach($vendors as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                         @endforeach
                    @endif
                </select>
            </div>
        </div>
    @endif

@if($type=="Driver")
        <div class="float-left form-group row" style="margin-left: 15px">
            <div class="col-sm-12">
                <input type="text" name="search_table" class="form-control btn-pill " id="search_table" placeholder="Civil Id Or Mobile" value="" required="" autocomplete="off">
            </div>
        </div>
        <div class="float-left form-group row" style="margin-left: 15px">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary" onclick="search($('#filter').val());">search</button>
            </div>
        </div>

@endif



<div class="float-right" style="margin-right: 30px;">
   <a class="btn btn-primary" href="{{$routeAdd}}"><i class="fa fa-fw fa-plus"></i> {{__("Add $type")}}</a>
</div>
</div>
