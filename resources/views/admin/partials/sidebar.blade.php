@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar"  style="height: 580px !important;overflow-y: auto;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(1) == '' ? 'active' : '' }}">
                <a href="{{ url('/admin/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>


            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">Content Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                <li class="{{ $request->segment(2) == 'home-page' ? 'active active-sub' : '' }}">
                    <a href="">
                        <i class="fa fa-briefcase"></i>
                        <span class="title">
                            Home Page
                        </span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'header-section' ? 'active active-sub' : '' }}">
                    <a href="{{route('admin.header.index')}}">
                        <i class="fa fa-briefcase"></i>
                        <span class="title">
                            Header Section
                        </span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'footer-section' ? 'active active-sub' : '' }}">
                    <a href="{{route('admin.footer.index')}}">
                        <i class="fa fa-briefcase"></i>
                        <span class="title">
                            Footer Section
                        </span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'visa-page' ? 'active active-sub' : '' }}">
                    <a href="">
                        <i class="fa fa-user"></i>
                        <span class="title">
                            Visa Page
                        </span>
                    </a>
                </li>

                </ul>
            </li>


        </ul>
    </section>
</aside>
