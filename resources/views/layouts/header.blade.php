<header id="site_header">
  <nav class="navbar">
    <div class="navbar-left">
      <a href="/" class="navbar_logo" title="Go to Home Page">
        {{--<img src="{{ asset('img/logo.png') }}" alt="Group Calendar Logo">--}}
        <img src="https://via.placeholder.com/150x45.png?text=logo" alt="Group Calendar Logo">
      </a>
    </div>
    @auth
    <div class="navbar_right">
      <a href="/notifications" class="navbar_item">
        {{--icon or count badge--}} Notifications
      </a>
      <div class="navbar_item navbar_dropdown">
        <a class="dropdown_toggle">
          <img class="navbar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} avatar">
          <span>{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown_items">
          <a href="{{ route('profile.index') }}" class="dropdown_item">My Profile</a>
          <a href="{{ route('groups.index') }}" class="dropdown_item">My Groups</a>
          <a href="{{ route('logout') }}" class="dropdown_item">Logout</a>
          <div class="dropdown_footer"></div>
        </div>
      </div>
    </div>
    @else
    <div class="navbar_right">
      <a href="{{ route('login') }}" class="navbar_item">Login</a>
      <a href="{{ route('demo') }}" class="navbar_item">Try a Demo</a>
    </div>
    @endif
  </nav>
</header>