@extends('front-end.master')
@section('title')
    Subscription  status
@endsection
@section('page-title')
    Subscription  status
@endsection
@section('body')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        @if($front_user->subscription_status == 1)
                            <h3 class="text-black text-center">Your subscription status is <span class="text-success text-center">active </span></h3>
                            <p style="  text-align: center;
  font-size: 60px;
  margin-top: 0px;" id="demo"></p>

                            <script>
                                // Set the date we're counting down to
                                var countDownDate = new Date("{{

                                            $exp = date("Y-m-d", strtotime(date("Y-m-d",strtotime($front_user->pay_time))."30 day"))

                                }}").getTime();

                                // Update the count down every 1 second
                                var x = setInterval(function() {

                                    // Get today's date and time
                                    var now = new Date().getTime();

                                    // Find the distance between now and the count down date
                                    var distance = countDownDate - now;

                                    // Time calculations for days, hours, minutes and seconds
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    // Output the result in an element with id="demo"
                                    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                                        + minutes + "m " + seconds + "s ";

                                    // If the count down is over, write some text
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("demo").innerHTML = "EXPIRED";
                                    }
                                }, 1000);
                            </script>
                        @empty(!$front_user->payer_id)
                            <div class="text-center mt-3">
                                <a href="{{route('/cancel-sub',[
                           'id'  => $front_user->payer_id
                           ])}}" class="btn btn-danger">Cancel subscription</a>
                            </div>
                            <br>
                            <table class="table table-bordered ">
                                <tr class="">
                                    <th>Next billing date</th>
                                    <th>{{$AgreementDetails->agreement_details->next_billing_date}}</th>
                                </tr>

                                <tr class="">
                                    <th>Last payment date</th>
                                    <th>{{$AgreementDetails->agreement_details->last_payment_date}}</th>
                                </tr>
                            </table>
                            @endempty
                        @else
                            <h3 class="text-black text-center">Your subscription status is <span class="text-danger text-center">inactive </span></h3>
                            @empty(!$front_user->payer_id)
                            <div class="text-center mt-3">
                                <a href="{{route('/active-sub')}}" class="btn btn-success">Active subscription</a>
                            </div>

                            <br>
                            <table class="table table-bordered ">
                                <tr class="">
                                    <th>Next billing date</th>
                                    <th>{{$AgreementDetails->agreement_details->next_billing_date}}</th>
                                </tr>

                                <tr class="">
                                    <th>Last payment date</th>
                                    <th>{{$AgreementDetails->agreement_details->last_payment_date}}</th>
                                </tr>
                            </table>
                            @endempty
                            @if($front_user->pay_vai = "begateway")
                                <div class="text-center mt-3">
                                    <a href="{{route('/begateway')}}" class="btn btn-success">Active subscription</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection