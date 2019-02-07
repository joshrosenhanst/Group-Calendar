<header id="site_header" class="navbar">
  <nav class="navbar">
      <div class="navbar-left">
        <a href="/" id="site_logo" class="navbar-item">Logo</a>
      </div>
      @auth
      <div class="navbar-right">
        <a href="/notifications" class="navbar-item">
          {{--icon or count badge--}} Notifications
        </a>
        <div class="navbar-item dropdown">
          <a class="navbar-dropdown-toggle">
            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }} avatar">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-items">
            <a href="{{ route('profile.index') }}" class="dropdown-item">My Profile</a>
            <a href="{{ route('groups.index') }}" class="dropdown-item">My Groups</a>
            <hr class="dropdown-divider">
            <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
          </div>
        </div>
      </div>
      @else
      <div class="navbar-right">
        <a href="{{ route('login') }}" class="navbar-item">Login</a>
        <a href="{{ route('demo') }}" class="navbar-item">Try a Demo</a>
      </div>
      @endif
  </nav>
</header>