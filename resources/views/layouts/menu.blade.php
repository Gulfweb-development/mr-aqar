<div class="vertical-menu-main">
    <nav id="main-nav">
        <!-- Sample menu definition -->
        <ul id="main-menu" class="sm pixelstrap">
            <li>
                <div class="text-right mobile-back">
                    {{__('Back')}}<i class="fa fa-angle-right pl-2" aria-hidden="true"></i>
                </div>
            </li>


               <li><a href="{{route("dashboard")}}"><i class="icon-desktop font-primary"></i> {{__('Dashboard')}}</a></li>

                <li><a href="#"><i class="icon-files font-success"></i>{{__('Advertising')}}</a>
                    <ul>
                        <li><a href="{{route('advertising.index')}}">{{__('Individual Advertising')}}</a></li>
                        <li><a href="{{route('advertising.indexCompanies')}}">{{__('Companies Advertising')}}</a></li>
                        <li><a href="{{route('advertising.createForm')}}">{{__('Create Advertising')}}</a></li>
                    </ul>
                </li>


                <li><a href="#"><i class="icon-package font-info"></i>{{__('Packages')}}</a>
                    <ul>
                        <li><a href="{{route('packages.index')}}">{{__('long-term subscription')}}</a></li>
                        <li><a href="{{route('staticPackages.index')}}">{{__('Pay as you go')}}</a></li>

{{--                        <li><a href="{{route('packages.create')}}">{{__('Add New Package')}}</a></li>--}}

                        {{--<li><a href="#">{{__('History')}}</a></li>--}}
                    </ul>
                </li>

            <li><a href="{{route('payments.index')}}"><i class="icon-money font-danger"></i>{{__('Payments')}}</a></li>
            <li><a href="#"><i class="icon-user font-success"></i>{{__('User')}}</a>
                <ul>
                    <li><a href="{{route("administrators.index")}}">{{__('Admin Users')}}</a></li>
                    <li><a href="{{route("members.index")}}">{{__('Members')}}</a></li>
{{--                    <li><a href="{{route("members.notActiveIndividual")}}">{{__('Members( Waiting for Verify)')}}</a></li>--}}
                </ul>
            </li>

            <li><a href="{{route('messages.index')}}"><i class="icon-comment-alt font-danger"></i>{{__('messages')}}</a></li>




{{--            <li><a href="#"><i class="icon-bar-chart font-primary"></i>{{__('Reports')}}</a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{route('reports.index')}}">{{__('Package Report')}}</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

            <li><a href="#"><i class="icon-settings font-secondary"></i>{{__('Settings')}}</a>
                <ul>
                    <li><a href="{{route('areas')}}">{{__('Areas')}}</a></li>
                    <li><a href="{{route('cities')}}">{{__('City')}}</a></li>

{{--                    <li><a href="{{route('amenties')}}">{{__('Amenties')}}</a></li>--}}
                    <li><a href="{{route('venueType')}}">{{__('Venue Type')}}</a></li>
{{--                    <li><a href="{{route('settings.invalidKeywords')}}">{{__('Invalid Keywords')}}</a></li>--}}
{{--                    <li><a href="">{{__('Translation')}}</a></li>--}}
                    <li><a href="{{route("settings.index")}}">{{__('Settings')}}</a></li>
                </ul>


            </li>
{{--            <li><a href="#"><i class="icon-headphone-alt font-secondary"></i>{{__('Website')}}</a>--}}
{{--                <ul>--}}
{{--                    <li><a href="#">{{__('Website logo')}}</a></li>--}}
{{--                    <li><a href="#">{{__('Slideshow')}}</a></li>--}}
{{--                    <li><a href="#">{{__('About us')}}</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

        </ul>
    </nav>
</div>
