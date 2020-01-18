@extends('front-end.master')
@section('title')
    Profile
@endsection
@section('page-title')
    Profile
@endsection
@section('body')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="col-md-6" style="margin: 0 auto">
                            <form action="{{route('/user-profile-update')}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Name</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->name}}" name="name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Email</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->email}}" disabled type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Whatsapp no</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->whatsapp_no}}"  name="whatsapp_no" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Address</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->address}}" name="address" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Password</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input   name="password" type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Tiktok username</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->tiktok_username}}" name="tiktok_username" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Tiktok password</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input disabled value="{{$front_user->tiktok_password}}" name="tiktok_password" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Tiktok county</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->tiktok_county}}" name="tiktok_county" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-sm-4">Tiktok target interest</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->tiktok_target_interest}}" name="tiktok_target_interest" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md4 col-sm-4">Tiktok follower no</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="{{$front_user->tiktok_follower_no}}" name="tiktok_follower_no" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md4 col-sm-4"></label>
                                    <div class="col-md-8 col-sm-8">
                                        <input value="Change"  type="submit" class="btn btn-success btn-block">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection