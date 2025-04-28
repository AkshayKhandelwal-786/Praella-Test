<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title') {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/images/favicon.png') }}">
    <link href="{{ url('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/libs/SnackBar-master/dist/snackbar.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ url('assets/libs/dropify-master/dist/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
    rel="stylesheet">
    <link href="{{ url('dist/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('plugin/toastr/toastr.min.css') }}"/>
    @yield('page-style')
</head>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
