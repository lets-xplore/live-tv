<div class="topbar">
    <div class="topbar-left">
        <a href="{{ URL::to('admin/dashboard') }}" class="logo">
            <span>
                <img src="{{asset('image/logo.png') }}" class="admin-logo" alt="Site Logo">
            </span>
            <i class="mdi mdi-layers"></i></a>
    </div>
    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <ul class="nav navbar-nav list-inline navbar-left">
                <li class="list-inline-item">
                    <button class="button-menu-mobile open-left"> <i class="mdi mdi-menu"></i> </button>
                </li>
                <li class="list-inline-item">
                    <h4 class="page-title">{{ isset($page_title) ? $page_title : 'Default Title' }}</h4>

                </li>
            </ul>
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <li>
                        <!-- Notification -->
                        <!--<div class="notification-box">
                    <ul class="list-inline mb-0">
                        <li>
                            <a href="{{ URL::to('/') }}" class="right-bar-toggle" data-toggle="tooltip" title="Front End" target="_blank">
                                <i class="fa fa-desktop"></i>
                            </a>

                        </li>
                    </ul>
                </div>-->
                        <!-- End Notification bar -->
                    </li>
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">



                            <img src="{{ asset('image/favicon.png')  }}" alt="person" class="rounded-circle" />



                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                            <a href="{{ URL::to('admin/logout') }}" class="dropdown-item notify-item fsize">
                                <i class="ti-power-off m-r-5"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
