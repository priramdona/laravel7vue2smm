
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="/css/app.css">

<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
   
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
           
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }} <i class="fas fa-power-off"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/smm.png" alt="SMM Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sarana Makin Mulia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
            <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer"></i>
                <p>
                    Dashboard
                </p>
                </router-link>
            </li>
            
            <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-sign-out"></i>
                <p>
                    Request Product
                </p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-sign-in"></i>
                <p>
                    Putaway Product
                </p>
                </router-link>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-briefcase"></i>
                <p>
                    Products
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <router-link to="/products" class="nav-link">
                            <i class="far fa-archive nav-icon"></i>
                            <p>Locations</p>
                        </router-link>
                        </li>
                <li class="nav-item">
                    <router-link to="/products" class="nav-link">
                        <i class="far fa-calculator nav-icon"></i>
                        <p>Units</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/products" class="nav-link">
                        <i class="far fa-cubes nav-icon"></i>
                        <p>Products</p>
                    </router-link>
                </li>
                </ul>
            </li>
        
            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                Employees
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-sitemap nav-icon"></i>
                    <p>Departements</p>
                </a>
                </li>
                <li class="nav-item">
                <router-link to="/employes" class="nav-link">
                    <i class="far fa-users nav-icon"></i>
                    <p>Employees</p>
                </router-link>
                </li>
            </ul>
            </li>
            
            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                User Settings
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                    <i class="far fa-user nav-icon"></i>
                    <p>Profile</p>
                </router-link>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-key nav-icon"></i>
                    <p>Change Password</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-power-off nav-icon"></i>
                    <p>Logout</p>
                </a>
                </li>
            </ul>
            </li>
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Test Laravel 7 Vue JS 2
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2025 <a href="https://smm.com">PT.SMM</a>.</strong> PT Sarana Makin Mulia.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>

</body>
</html>
