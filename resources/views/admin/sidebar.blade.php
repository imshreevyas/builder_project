<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url("/dashboard")}}" class="app-brand-link">
            <img src="storage/app/" style="height: 38px;width: 150px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{request()->segment(1)=='dashboard'?'active':'' }}">
            <a href="{{url('admin/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{request()->segment(1)=='myAccount'?'active':''}}">
            <a href="{{url('admin/myAccount')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Account</div>
            </a>
        </li>

        <li class="menu-item {{ request()->segment(1) == 'allUsers' ? 'open':'' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div data-i18n="Layouts">Users</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(1)=='allUsers' ? 'active':''}}">
                    <a href="{{url('/admin/allUsers')}}" class="menu-link">
                        <div data-i18n="Without navbar">Manage</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->segment(1) == 'allPackages' ?'open':'' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-gift"></i>
                <div data-i18n="Layouts">Packages</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(1)=='allPackages'?'active':''}}">
                    <a href="{{url('/admin/allPackages')}}" class="menu-link">
                        <div data-i18n="Without navbar">Manage</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="{{url('/admin/allSupport')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-phone"></i>
                <div data-i18n="Analytics">Support</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{url('/admin/settings')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Settings</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('adminLogout')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-exit"></i>
                <div data-i18n="Analytics">Logout</div>
            </a>
        </li>
    </ul>
</aside>