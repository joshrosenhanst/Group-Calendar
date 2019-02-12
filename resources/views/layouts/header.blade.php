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
        <span class="icon">@materialicon('bell')</span>
        <span>Notifications</span>
      </a>
      <div class="navbar_item navbar_dropdown">
        <a class="dropdown_toggle">
          <img class="navbar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} avatar">
          <span>{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown_items">
            <a href="{{ route('events.calendar') }}" class="dropdown_item">
              <span class="icon">@materialicon('calendar-range')</span>
              <span>My Calendar</span>
            </a>
            <a href="{{ route('groups.index') }}" class="dropdown_item">
              <span class="icon">@materialicon('account-group')</span>
              <span>My Groups</span>
            </a>
            <a href="{{ route('groups.index') }}" class="dropdown_item">
              <span class="icon">@materialicon('account')</span>
              <span>My Profile</span>
            </a>
            <a href="{{ route('logout') }}" class="dropdown_item">
              <span class="icon">@materialicon('logout')</span>
              <span>Log Out</span>
            </a>
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