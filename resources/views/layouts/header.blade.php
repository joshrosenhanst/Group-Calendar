<header id="site_header">
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar_left">
      <a href="/" class="navbar_logo navbar_item" title="GroupCalendar">
        @materialicon('calendar-heart')
        <span>GroupCalendar</span>
      </a>
    </div>
    @auth
    <div class="navbar_right">
      
      <notification-display
        v-bind:user_id="currentUser.id"
        v-bind:count="currentUnreadCount"
      >
        @include('partials.notifications', [
          'notifications'=>Auth::user()->all_unread_notifications
        ])
      </notification-display>

      <a href="{{ route('home') }}" class="navbar_item" title="Go to Home Page">
        <img class="navbar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} avatar">
        <span class="navbar_item_text">{{ Auth::user()->name }}</span>
      </a>
      <a href="{{ route('logout') }}" class="navbar_item">
        <span class="icon">@materialicon('logout')</span>
        <span class="navbar_item_text">Log Out</span>
      </a>
      <navbar-menu-button
        v-on:navbar-menu-toggle="onNavbarButtonToggle"
        whitelist="#sidebars"
      ></navbar-menu-button>
    </div>
    @else
    <div class="navbar_right">
      <a href="{{ route('login') }}" class="navbar_item">Login</a>
      <a href="{{ route('demo') }}" class="navbar_item">Try a Demo</a>
    </div>
    @endif
  </nav>
</header>