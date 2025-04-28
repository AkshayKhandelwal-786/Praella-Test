@extends('layouts.app')
@section('title', 'Dashboard |')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4>Dashboard</h4>
            </div>
            @if($roleName != $userRole)
                <div class="col-md-6 col-lg-4">
                    <a href="">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white">{{ $user }}</h1>
                                <h6 class="text-white">Total Users</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white">{{ $project }}</h1>
                                <h6 class="text-white">Total Projects</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white">{{ $task }}</h1>
                                <h6 class="text-white">Total Task</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white">{{ $role }}</h1>
                                <h6 class="text-white">Total Role</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @else
                <div class="user-dashboard">
                    <h1>Welcome to {{ Auth::guard('web')->user()->name }}</h4>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
