      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{$activePage == 'dashboard' ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('employees.index') }}" class="nav-link {{$activePage == 'employees' ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employees
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('duties.index') }}" class="nav-link {{$activePage == 'duties' ? 'active' : ''}}">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Duties Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('leaves.index') }}" class="nav-link {{$activePage == 'leaves' ? 'active' : ''}}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Leaves Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('records.index') }}" class="nav-link {{$activePage == 'records' ? 'active' : ''}}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Record Logs
              </p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="{{ route('references') }}" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                References
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>