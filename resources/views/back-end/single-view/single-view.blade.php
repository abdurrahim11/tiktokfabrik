@extends('back-end.master')
@section('title')
    Manage User
@endsection
@section('page-title')
    Manage User
@endsection
@section('body')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-bordered ">
                            <tr class="">
                                <th>Name</th>
                                <th>{{$front_user->name}}</th>
                            </tr>
                            <tr class="">
                                <th>Email</th>
                                <th>{{$front_user->email}}</th>
                            </tr>
                            <tr class="">
                                <th>Whatsapp no</th>
                                <th>{{$front_user->whatsapp_no}}</th>
                            </tr>
                            <tr class="">
                                <th>Address</th>
                                <th>{{$front_user->whatsapp_no}}</th>
                            </tr>
                            <tr class="">
                                <th>Tiktok username</th>
                                <th>{{$front_user->tiktok_username}}</th>
                            </tr>
                            <tr class="">
                                <th>Tiktok password</th>
                                <th>{{$front_user->tiktok_password}}</th>
                            </tr>
                            <tr class="">
                                <th>Tiktok county</th>
                                <th>{{$front_user->tiktok_county}}</th>
                            </tr>
                            <tr class="">
                                <th>Tiktok target interest</th>
                                <th>{{$front_user->tiktok_target_interest}}</th>
                            </tr>
                            <tr class="">
                                <th>Tiktok follower no</th>
                                <th>{{$front_user->tiktok_follower_no}}</th>
                            </tr>
                            <tr class="">
                                <th>Next billing date</th>
                                <th>{{$AgreementDetails->agreement_details->next_billing_date}}</th>
                            </tr>

                            <tr class="">
                                <th>Last payment date</th>
                                <th>{{$AgreementDetails->agreement_details->last_payment_date}}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection