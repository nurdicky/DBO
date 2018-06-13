<?php $url = Route::getCurrentRoute()->uri ?>

<nav class="sidebar sidebar-offcanvas bg-gradient-danger" id="sidebar">
  <ul class="nav">

    <li class="nav-item <?php ($url == 'home') ? 'active' : '';?>">
      <a class="nav-link " href="{{ route('home')}}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php ($url == 'mobil') ? 'active' : '';?>">
      <a class="nav-link " href="#">
        <span class="menu-title">Data Mobil</span>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php ($url == 'petugas') ? 'active' : '';?>">
      <a class="nav-link" href="#">
        <span class="menu-title">Data Petugas</span>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
    </li>


  </ul>
</nav>
