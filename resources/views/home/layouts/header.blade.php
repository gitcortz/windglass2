<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>GAS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>phil</b>Gas</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <div href="javascript:void(0)" style="font-weight:bold; position: relative; display: none; padding: 15px 15px; color:#fff">{{ session('branch_name') }}</div>
            <div style="margin: 10px 10px;padding:5px;font-weight:bold;border:1px solid #fff"><span style="color:#fff">Branch:</span>
            <select id="header_branch_selection"></select>
            </div>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image" style="display:none">
              <span class="hidden-xs"> {{Auth::user()->name}} </span>
            </a>
            <ul class="dropdown-menu" style="width:65px">
              <!-- User image -->
              <li class="user-header" style="height:100px;">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" style="display:none">
                <p>
                  {{Auth::user()->name}} 
                </p>
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->              
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears" style="display:none"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>