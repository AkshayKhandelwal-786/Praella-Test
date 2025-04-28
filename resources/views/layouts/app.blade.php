@include('includes.styles')
<div id="main-wrapper">
@auth
    @include('includes.header')
    @include('includes.sidebar')
@endauth
    @yield('content')
</div>
@include('includes.scripts')
