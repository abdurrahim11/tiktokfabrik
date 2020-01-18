@extends('front-end.master')
@section('title')
    Dashboard
@endsection
@section('page-title')
    Dashboard
@endsection
@section('body')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                       <div class="text-center text-success">
                           <h2 class="p-5">Welcome {{$front_user->name}}</h2>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection