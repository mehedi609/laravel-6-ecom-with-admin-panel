<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{asset('assets/backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset("images/admin/admin_photos/".Auth::guard('admin')->user()->image)}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          @php
            $dashboard_url = Request::is('admin/dashboard');
          @endphp
          <a
            href="{{route('admin.dashboard')}}"
            class="nav-link {{$dashboard_url ? 'active' : ''}}"
          >
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview menu-open">
          @php
            $settings_url = Request::is('admin/settings');
            $update_details_url = Request::is('admin/update-details');
          @endphp
          <a
            href="#"
            class="nav-link {{$settings_url || $update_details_url ? 'active' : ''}}">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Admin Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a
                href="{{route('admin.settings')}}"
                class="nav-link {{$settings_url ? 'active' : ''}}"
              >
                <i class="far fa-circle nav-icon"></i>
                <p>Update Admin Password</p>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="{{route('admin.update.details')}}"
                class="nav-link {{$update_details_url ? 'active' : ''}}"
              >
                <i class="far fa-circle nav-icon"></i>
                <p>Update Admin Details</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">EXAMPLES</li>
        <li class="nav-item">
          <a href="pages/calendar.html" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Calendar
              <span class="badge badge-info right">2</span>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
