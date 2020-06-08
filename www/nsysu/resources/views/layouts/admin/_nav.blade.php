<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{ route('index') }}">@lang('admin/common.system')</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <!-- Side Nav -->
        <ul class="navbar-nav navbar-sidenav" id="sideNav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-link-text">@lang('admin/common.home')</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('news.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-link-text">@lang('admin/nav.newManage')</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-link-text">@lang('admin/nav.contact')</span>
                </a>
            </li>
        </ul>
        <!-- Side Nav -->
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        </ul>


        <!-- Top Nav -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="settingDropdown" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-gear"></i>
                    {{-- <span class="indicator text-danger d-none d-lg-block">
                      <i class="fas fa-circle"></i>
                    </span> --}}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settingDropdown">
                    <h6 class="dropdown-header">@lang('admin/common.setting')</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="{{ route('logout') }}">@lang('admin/common.logout')</a>
                </div>
            </li>
        </ul>
        <!-- Top Nav -->
    </div>
</nav>
