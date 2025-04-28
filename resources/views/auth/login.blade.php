@extends('layouts.app')
@section('title', 'Login |')
@section('content')
    <div class="">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-secondary" style="background-color: #ffffff!important">
                <img src="{{ url('images/logo.png') }}" alt="Logo" class="img-center" width="150px">
                <div id="loginform">
                    <form autocomplete="off" class="form-horizontal m-t-20"
                        id="loginform" action="{{ route('store-login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="mb-3">
                                    <input autocomplete="off" type="text"
                                    id="email" name="email"
                                    class="form-control form-control-lg
                                    {{ $errors->has('email') ? 'has-error' : '' }}"
                                    placeholder="Email"
                                    value="{{ old('email') }}"
                                    aria-label="Email"
                                    aria-describedby="basic-addon1"
                                    >
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input name="password" id="password"
                                    type="password" class="form-control form-control-lg
                                    {{ $errors->has('password') ? 'has-error' : '' }}"
                                    placeholder="Password"
                                    value="{{ old('password') }}"
                                    aria-label="Password"
                                    aria-describedby="basic-addon1"
                                    >
                                    <span class="fa fa-fw fa-eye field-icon toggle-password" data-id="password"></span>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a href="{{ route('register') }}"
                                            class="btn btn-info" id="to-recover" type="button">
                                            <i class="fa fa-user-plus m-r-5"></i>
                                            Create a account
                                        </a>
                                        <button id="submit-btn" class="btn btn-success float-right" type="submit">
                                            <span id="licon"></span>Login
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script src="{{ url('js/main.js') }}"></script>
@endsection
