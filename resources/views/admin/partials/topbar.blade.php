<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->

        <span class="logo-mini">
          <img src="{{ url('img/logo/logo.jpg') }}" alt="" height="40px" width="40px">
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           <p><img src="{{ url('img/logo/logo.jpg') }}" alt="" height="35px" width="35px"> &nbsp;{{ env('APP_NAME') }}</p></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a> -->
        <div class="container">
         <div class="row">
              <div class="col-md-10 text-right" style="padding-left: 0px">
                <ul class="nav navbar-nav navbar-right">
                      <!-- Authentication Links -->

                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                  {{ Auth::user()->first_name }} {{ Auth::user()->last_name && Auth::user()->last_name != null ? Auth::user()->last_name : "" }} <span class="caret"></span>
                              </a>

                              <ul class="dropdown-menu" role="menu">
                                  <li>
                                      <a href="{{ route('auth.logout') }}"
                                          onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                          Logout
                                      </a>

                                      <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                  </li>
                              </ul>
                          </li>
                  </ul>
                </div>
            </div>
          </div>
        </div>


    </nav>
</header>
