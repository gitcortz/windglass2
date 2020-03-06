 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <!--div class="user-panel">
      <div class="pull-left image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div-->   
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      {{-- dashboard --}}
      <li class="active">
        <a href="/">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      {{-- POS --}}
      <li>
        <a href="{{ route('pos') }}">
          <i class="fa fa-th"></i> <span>POS</span>
        </a>
      </li>      
      <li class="treeview 
          {{ (request()->is('reports/dailysales')) 
              ? 'menu-open ' : '' }}">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Sales</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu 
            {{ (request()->is('reports/dailysales')) ? 
                  'block' : '' }}" >
          <li><a href="{{ route('reportdailysales') }}"><i class="fa fa-circle-o"></i> Daily Sales</a></li>
          <li><a href="{{ route('reports') }}"><i class="fa fa-circle-o"></i> Pending Sales</a></li>
        </ul>
      </li>
      <li class="treeview {{ (request()->is('brands')) 
                            || (request()->is('producttypes')) 
                            || (request()->is('products')) 
                            || (request()->is('stocks')) 
                            || (request()->is('stocktransfers')) 
                              ? 'menu-open ' : '' }}">
        <a href="#">
          <i class="fa fa-table"></i> <span>Inventory</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu {{ (request()->is('brands')) 
                            || (request()->is('producttypes')) 
                            || (request()->is('products')) 
                            || (request()->is('stocks')) 
                            || (request()->is('stocktransfers')) 
                              ? 'block ' : '' }}">
          <li><a href="{{ route('brands') }}"><i class="fa fa-circle-o"></i> Brands</a></li>
          <li><a href="{{ route('producttypes') }}"><i class="fa fa-circle-o"></i> Product Types</a></li>
          <li><a href="{{ route('products') }}"><i class="fa fa-circle-o"></i> Products</a></li>
          <li><a href="{{ route('stocks') }}"><i class="fa fa-circle-o"></i> Stocks</a></li>
          <li><a href="{{ route('stocktransfers') }}"><i class="fa fa-circle-o"></i> Stock Transfers</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Stock Movement</a></li>
        </ul>
      </li>
      <li class="treeview {{ (request()->is('employeetypes')) 
                            || (request()->is('employees')) 
                            || (request()->is('employeeloans')) 
                            || (request()->is('timesheetdetails')) 
                            || (request()->is('payrolls')) 
                              ? 'menu-open ' : '' }}">
        <a href="#">
          <i class="fa fa-table"></i> <span>HR Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu {{ (request()->is('employeetypes')) 
                            || (request()->is('employees')) 
                            || (request()->is('employeeloans')) 
                            || (request()->is('timesheetdetails')) 
                            || (request()->is('payrolls')) 
                              ? 'block ' : '' }}">
          <li><a href="{{ route('employeetypes') }}"><i class="fa fa-circle-o"></i> Employee Types</a></li>
          <li><a href="{{ route('employees') }}"><i class="fa fa-circle-o"></i> Employees</a></li>
          <li><a href="{{ route('employeeloans') }}"><i class="fa fa-circle-o"></i> Loans</a></li>
          <li><a href="{{ route('timesheetdetails') }}"><i class="fa fa-circle-o"></i> Timesheets</a></li>
          <li><a href="{{ route('payrolls') }}"><i class="fa fa-circle-o"></i> Payrolls</a></li>
        </ul>
      </li>
    
      <li class="header">Administration</li>
      {{-- POS --}}
      <li>
        <a href="{{ route('cities') }}">
          <i class="fa fa-book"></i> <span>Location</span>
        </a>
      </li>
      {{-- Branches --}}
      <li>
        <a href="{{ route('branches') }}">
          <i class="fa fa-book"></i> <span>Branch</span>
        </a>
      </li>
      {{-- Users --}}
      <li>
        <a href="{{ route('users') }}">
          <i class="fa fa-user"></i> <span>User</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>


