<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="menu-link {{ classActivePath('dashboard') }}"><i class="fa fa-home"></i>
                        <span> Dashboard</span></a></li>

                <li><a href="{{ route('admin.import.video') }}" class="menu-link {{ classActivePath('import-video') }}"><i class="fa fa-upload"></i>
                        <span> Import Video</span></a></li>

                <li>
                    <a href="{{ route('admin.category') }}" class="menu-link {{ classActivePath('category') }}"><i class="fa fa-folder"></i>
                        <span> Clinic</span>
                    </a>
                </li>

                <li><a href="{{ route('admin.videos') }}" class="menu-link {{ classActivePath('admin.videos') }}"><i class="fa fa-film"></i>
                        <span> Videos</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="menu-link" id="resetDataBtn">
                        <i class="fa fa-refresh"></i>
                        <span> Reset Data</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
