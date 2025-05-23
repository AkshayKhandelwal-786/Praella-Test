<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none"
            href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand text-center" href="{{ route('admin.dashboard') }}">
                <!-- Logo text -->
                <span class="logo-text m-auto">
                    <!-- dark Logo text -->
                    <img src="{{ url('images/logo.png') }}"
                    alt="homepage"
                    width="150px"
                    class="light-logo" />
                </span>
            </a>
            
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block">
                    <a href="#" class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                    data-sidebartype="mini-sidebar">
                        <i class="mdi mdi-menu font-24"></i>
                    </a>
                </li>
               
        </ul>
        <!-- ============================================================== -->
        <!-- Right side toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav float-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted
                waves-effect waves-dark pro-pic"
                href=""
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                    @if(!empty(\Auth::user()->profile_picture))
                        <img src="{{ url(Auth::user()->profile_picture) }}"
                        alt="{{ \Auth::user()->name }}"
                        class="rounded-circle"
                        width="31">
                    @else
                        <img src="{{ url('assets/images/users/1.jpg') }}"
                        alt="{{ \Auth::user()->name }}"
                        class="rounded-circle"
                        width="31">
                    @endif
                    &nbsp;
                    {{\Auth::user()->name}}
                </a>
                <div class="dropdown-menu dropdown-menu-right user-dd animated">
                    <a class="dropdown-item"
                    href="">
                        <i class="ti-user m-r-5 m-l-5"></i> My Profile
                    </a>
                    <a class="dropdown-item"
                    href="">
                        <i class="ti-key m-r-5 m-l-5"></i>Change Password
                    </a>
                    <a class="dropdown-item"
                    onclick="return confirm('Are you sure you want logout?')"
                    href="{{ route('admin.logout') }}">
                        <i class="fa fa-power-off m-r-5 m-l-5"></i>Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
    </nav>
</header>
