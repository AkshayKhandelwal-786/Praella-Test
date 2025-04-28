@extends('layouts.app')
@section('title', 'Register |')
@section('content')
    <div class="">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-secondary" style="background-color: #ffffff!important">
                <img src="{{ url('images/logo.png') }}" alt="Logo" class="img-center" width="150px">
                <div id="loginform">
                    <form autocomplete="off" class="form-horizontal m-t-20"
                    id="loginform"
                    action="{{ route('store-register') }}"
                    method="post">
                        {{ csrf_field() }}
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="mb-3">
                                    <input autocomplete="off" type="text"
                                    id="name" name="name"
                                    class="form-control form-control-lg
                                    {{ $errors->has('name') ? 'has-error' : '' }}"placeholder="Name"
                                    value="{{ old('name') }}"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    maxlength="100"
                                    oninput="this.value =
                                    this.value.replace(/(\s{2,})|[^a-zA-Z0-9.]/g, ' ')
                                    .replace(/(\..*)\./g, '$1');"
                                    required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input autocomplete="off" type="email"
                                    id="email" name="email" class="form-control form-control-lg
                                    {{ $errors->has('email') ? 'has-error' : '' }}"placeholder="Email"
                                    value="{{ old('email') }}"
                                    aria-label="Email"
                                    aria-describedby="basic-addon1"
                                    required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input name="password" id="password"
                                    type="password" class="form-control form-control-lg
                                    {{ $errors->has('password') ? 'has-error' : '' }}" placeholder="Password"
                                    value="{{ old('password') }}"
                                    aria-label="Password"
                                    aria-describedby="basic-addon1"
                                    required>
                                    <span class="fa fa-fw fa-eye field-icon
                                    toggle-password" data-id="password"></span>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input name="confirm_password"
                                    id="confirm_password" type="password"
                                    class="form-control form-control-lg
                                    {{ $errors->has('confirm_password') ? 'has-error' : '' }}"
                                    placeholder="Confirm Password"
                                    value="{{ old('confirm_password') }}"
                                    aria-label="Confirm Password"
                                    aria-describedby="basic-addon1"
                                    required>
                                    <span class="fa fa-fw fa-eye field-icon
                                    toggle-password" data-id="confirm_password"></span>
                                    @if ($errors->has('confirm_password'))
                                        <span class="help-block">
                                            {{ $errors->first('confirm_password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a href="{{ route('login') }}"
                                        class="btn btn-info"
                                        id="to-recover"
                                        type="button">
                                            Sign in
                                        </a>
                                        <button id="submit-btn" class="btn btn-success float-right" type="submit">
                                            <i class="fa fa-user-plus m-r-5"></i>
                                            <span id="licon"></span>Register
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
