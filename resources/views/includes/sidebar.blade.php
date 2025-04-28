<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item {{ (Route::currentRouteName() == 'admin.dashboard') ?'selected' : '' }}">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                    href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if (Auth::guard('web')->user()->hasAnyPermission(
                    [
                        config('constant.add-project'),
                        config('constant.edit-project'),
                        config('constant.delete-project'),
                        config('constant.list-project')
                    ]
                ))
                    <li class="sidebar-item {{ in_array(Route::currentRouteName(),
                    ['projects.index','projects.create','projects.edit']) ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                        href="{{ route('projects.index') }}" aria-expanded="false">
                            <i class="mdi mdi-chemical-weapon"></i>
                            <span class="hide-menu">Projects</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->hasAnyPermission(
                    [
                        config('constant.add-task'),
                        config('constant.edit-task'),
                        config('constant.delete-task'),
                        config('constant.list-task')
                    ]
                ))
                    <li class="sidebar-item {{ in_array(Route::currentRouteName(),
                    ['tasks.index','tasks.create','tasks.edit','tasks.show']) ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                        href="{{ route('tasks.index') }}" aria-expanded="false">
                            <i class="mdi mdi-checkerboard"></i>
                            <span class="hide-menu">Tasks</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->hasAnyPermission(
                    [
                        config('constant.list-role'),
                        config('constant.assign-permission'),
                    ]
                ))
                    <li class="sidebar-item {{ in_array(Route::currentRouteName(),
                        ['roles.index','roles.edit',
                        'admin.assign-permission']) ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                        href="{{ route('roles.index') }}" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i>
                            <span class="hide-menu">Roles and Permission</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->hasAnyPermission(
                    [
                        config('constant.add-user'),
                        config('constant.edit-user'),
                        config('constant.delete-user'),
                        config('constant.list-user')
                    ]
                ))
                    <li class="sidebar-item {{ in_array(Route::currentRouteName(),
                    ['users.index','users.create','users.edit']) ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                        href="{{ route('users.index') }}" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i>
                            <span class="hide-menu">Users</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->hasAnyPermission(
                    [
                        config('constant.list-comment'),
                        config('constant.edit-user'),
                        config('constant.delete-user'),
                        config('constant.list-user')
                    ]
                ))
                    <li class="sidebar-item {{ in_array(Route::currentRouteName(),
                        ['comments.index','comments.show']) ? 'selected' : '' }}">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                        href="{{ route('comments.index') }}" aria-expanded="false">
                            <i class="mdi mdi-comment"></i>
                            <span class="hide-menu">Comments</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                    onclick="return confirm('Are you sure you want logout?')"
                    href="{{ route('admin.logout') }}"
                    aria-expanded="false">
                        <i class="mdi mdi-logout"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
<!-- End Sidebar scroll-->
</aside>
