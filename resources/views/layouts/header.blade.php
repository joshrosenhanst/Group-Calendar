<header id="site_header">
  <nav class="navbar">
    <div class="navbar_left">
      <a href="/" class="navbar_logo navbar_item" title="GroupCalendar">
        @materialicon('calendar-heart')
        <span>GroupCalendar</span>
      </a>
    </div>
    @auth
    <div class="navbar_right">
      <a href="/notifications" class="navbar_item" aria-label="Notifications" title="Notifications">
        <span class="icon">@materialicon('bell')</span>
      </a>
      <a href="{{ route('home') }}" class="navbar_item" title="Go to Home Page">
        <img class="navbar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} avatar">
        <span>{{ Auth::user()->name }}</span>
      </a>
      <a href="{{ route('logout') }}" class="navbar_item">
        <span class="icon">@materialicon('logout')</span>
        <span>Log Out</span>
      </a>
    </div>
    @else
    <div class="navbar_right">
      <a href="{{ route('login') }}" class="navbar_item">Login</a>
      <a href="{{ route('demo') }}" class="navbar_item">Try a Demo</a>
    </div>
    @endif
  </nav>
</header>