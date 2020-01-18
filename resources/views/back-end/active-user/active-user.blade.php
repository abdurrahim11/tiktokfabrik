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
                        <table class="table table-bordered text-center">
                            <tr class="">
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>User Status</th>
                                <th>details</th>
                            </tr>
                            @foreach($front_users as $front_user)
                                <tr>
                                    <td>{{$front_user->name}}</td>
                                    <td>{{$front_user->email}}</td>
                                    <td>@if($front_user->subscription_status == 1)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td><a href="{{route('/view/user-profile',['id'=>$front_user->id])}}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection