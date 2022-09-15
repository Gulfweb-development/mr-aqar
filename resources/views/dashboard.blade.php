@extends('layouts.admin', ['crumbs' => []])
@section('content')

        <div class="col-md-4 col-sm-12">
        <h6>{{__('Number Of Individual User')}}</h6>
        <div class="bg-info card browser-widget">
            <div class="media card-body">
                <i class="align-self-center mr-3"></i>
                <div class="media-body align-self-center">
                    <div>
                        <p><b>{{__('Today')}} </b></p>
                        <h4><span id="daily_individual_user" class="daily_individual_user">0</span></h4>
                    </div>
                    <div>
                        <p><b>{{__('Week')}} </b></p>
                        <h4><span id="weekly_individual_user" class="weekly_individual_user">0</span></h4>
                    </div>
                    <div>
                        <p><b>{{__('Month')}} </b></p>
                        <h4><span id="monthly_individual_user" class=" ">0</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-4 col-sm-12">
            <h6>{{__('Number Of Advertising')}}</h6>
            <div class="bg-success card browser-widget">
                <div class="media card-body">
                    <i class="align-self-center mr-3"></i>
                    <div class="media-body align-self-center">
                        <div>
                            <p><b>{{__('Today')}} </b></p>
                            <h4><span class="daily_advertising">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Week')}} </b></p>
                            <h4><span class="weekly_advertising">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Month')}} </b></p>
                            <h4><span class="monthly_advertising">0</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <h6>{{__('Number of Payment - Total Amount paid')}}</h6>
            <div class="bg-danger card browser-widget">
                <div class="media card-body">
                    <div class="media-img">
                        <img  src="assets/images/dashboard/firefox.png" alt=""/>
                    </div>
                    <i class="align-self-center mr-3"></i>
                    <div class="media-body align-self-center">
                        <div>
                            <p><b>{{__('Today')}} </b></p>
                            <h4><span class="daily_payment">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Week')}} </b></p>
                            <h4><span class="weekly_payment">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Month')}} </b></p>
                            <h4><span class="monthly_payment">0</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <h6>{{__('Number Of Corporate User')}}</h6>
            <div class="bg-info card browser-widget">
                <div class="media card-body">
                    <i class="align-self-center mr-3"></i>
                    <div class="media-body align-self-center">
                        <div>
                            <p><b>{{__('Today')}} </b></p>
                            <h4><span class="daily_company_user">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Week')}} </b></p>
                            <h4><span class="weekly_company_user">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Month')}} </b></p>
                            <h4><span class="monthly_company_user">0</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <h6>{{__('Number Of Ads View')}}</h6>
            <div class="bg-success card browser-widget">
                <div class="media card-body">
                    <i class="align-self-center mr-3"></i>
                    <div class="media-body align-self-center">
                        <div>
                            <p><b>{{__('Today')}} </b></p>
                            <h4><span class=" daily_ads_view">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Week')}} </b></p>
                            <h4><span class=" weekly_ads_view">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Month')}} </b></p>
                            <h4><span class=" monthly_ads_view">0</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-12">
            <h6>{{__('Number Of Call Click')}}</h6>
            <div class="bg-danger card browser-widget">
                <div class="media card-body">
                    <div class="media-img">
                        <img  src="assets/images/dashboard/firefox.png" alt=""/>
                    </div>
                    <i class="align-self-center mr-3"></i>
                    <div class="media-body align-self-center">
                        <div>
                            <p><b>{{__('Today')}} </b></p>
                            <h4><span class="daily_call_click">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Week')}} </b></p>
                            <h4><span class="weekly_call_click">0</span></h4>
                        </div>
                        <div>
                            <p><b>{{__('Month')}} </b></p>
                            <h4><span class="monthly_call_click">0</span></h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>



    <hr>

        <div class="col-md-6 col-sm-12">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-md-6 col-sm-12">
            <canvas id="myLineChart"></canvas>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        $(function () {
            $.ajax({
                url: '{{route('dashboardInfo')}}',
                method: 'GET'
            }).done(function(response) {
                $("#daily_individual_user").html(response.individualUser[0]);
                $("#weekly_individual_user").html(response.individualUser[1]);
                $("#monthly_individual_user").html(response.individualUser[2]);

                $(".daily_advertising").html(response.countAdvertising[0]);
                $(".weekly_advertising").html(response.countAdvertising[1]);
                $(".monthly_advertising").html(response.countAdvertising[2]);


                $(".daily_company_user").html(response.companyUser[0]);
                $(".weekly_company_user").html(response.companyUser[1]);
                $(".monthly_company_user").html(response.companyUser[2]);

                $(".daily_ads_view").html(response.countViewAdvertising[0]);
                $(".weekly_ads_view").html(response.countViewAdvertising[1]);
                $(".monthly_ads_view").html(response.countViewAdvertising[2]);

               $(".daily_call_click").html(response.countClickAdvertising[0]);
                $(".weekly_call_click").html(response.countClickAdvertising[1]);
                $(".monthly_call_click").html(response.countClickAdvertising[2]);


                $(".daily_payment").html(response.payments[0][0].count);
                $(".weekly_payment").html(response.payments[1][0].count);
                $(".monthly_payment").html(response.payments[2][0].count);


            });


            $.ajax({
                url: '{{route('charts')}}',
                method: 'GET'
            }).done(function(response) {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',

                        // The data for our dataset
                        data: {
                            labels: response.data.dailyChart.labels,
                            datasets: [{
                                label: 'Daily New Advertising',
                                backgroundColor: 'transparent',
                                borderColor: 'rgb(255, 99, 132)',
                                data: response.data.dailyChart.chartData
                            }]
                        },

                        // Configuration options go here
                        options: {}
                    });

                    var context = document.getElementById('myLineChart').getContext('2d');
                    var myLineChart = new Chart(context, {
                        type: 'line',
                        data: {
                            labels: response.data.totalChart.labels,
                            datasets: [{
                                label: 'Month New Advertising',
                                backgroundColor: 'transparent',
                                borderColor: 'rgb(64, 153, 255)',
                                data: response.data.totalChart.chartData
                            }]
                        },
                        options: {}
                    });
                });





        });


    </script>
@endsection
