<?php 
$route = Route::getCurrentRoute();
$prefix = $route->action['prefix']; 
$url = $route->uri; 

if ($prefix != null) {
  $url = explode('/',$prefix)[1];
}

?>

<nav class="sidebar sidebar-offcanvas bg-gradient-danger" id="sidebar">
  <ul class="nav">

    <li class="nav-item <?php ($url == 'home') ? 'active' : '';?>">
      <a class="nav-link " href="{{ route('home')}}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    
    <li class="nav-item <?php ($url == 'master') ? 'active' : '';?>">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Data Master</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('car.index')}}">Mobil</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('owner.index')}}">Pemilik</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('driver.index')}}">Pengemudi</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php ($url == 'employee') ? 'active' : '';?>">
      <a class="nav-link" href="{{ route('employee.index')}}">
        <span class="menu-title">Data Petugas</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php ($url == 'log') ? 'active' : '';?>">
      <a class="nav-link" href="{{ route('log.index')}}">
        <span class="menu-title">Data Log Aktivitas</span>
        <i class="mdi mdi-cached menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>
