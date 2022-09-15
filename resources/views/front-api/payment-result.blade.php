<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Payment Result</title>
</head>
<body>
<div class="container" style="margin-top:50px">
    <div class="row justify-content-center">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{optional($payment->package)->title_en}} Subscrbtion</h4>

                <p class="card-text">
                    Price : {{optional($payment)->price}}
                </p>
                <p class="card-text">
                    Result : <strong  @if($message=="CAPTURED")style="color:green;"  @else style="color:red;" @endif > {{$message}}</strong>
                </p>
                <h4 class="card-title">Transaction Details</h4>
{{--                <p class="card-text">--}}
{{--                    Order ID :  190823080600--}}
{{--                </p>--}}
                <p class="card-text">
                    Date : {{optional($payment)->updated_at}}
                </p>
                <p class="card-text">
                    Payment ID : {{optional($order)->payment_id}}
                </p>
                <p class="card-text">
                    Trans ID  : {{$order->tranid}}
                </p>
                <p class="card-text">
                    Track ID  : {{optional($order)->trackid}}
                </p>
                <p class="card-text">
                    Auth ID : {{optional($order)->auth}}
                </p>
                <p class="card-text">
                    Ref ID : {{$refId}}
                </p>

            </div>
        </div>


    </div>
    {{--    <div class="row justify-content-center">--}}
    {{--        <button type="button" class="btn btn-dark">Back To App</button>--}}
    {{--    </div>--}}
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>