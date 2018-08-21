<?php
$id = Auth::user()->last_login;
if ( $id != null ) {
  $user = App\User::find($id);
}
else{
  $user = Auth::user();
}

?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="/home">Bea Cukai Nanga Badau</a>
    <a class="navbar-brand brand-logo-mini" href="/home"><img src="{{ asset('public/assets/images/web_hi_res_512.png')}}" alt="logo"></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-text">
            <p class="mb-1 text-black">{{ $user->name }}</p>
            <span class="availability-status online"></span>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">

            <i class="mdi mdi-logout mr-2 text-primary"></i>
            Signout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>

    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
