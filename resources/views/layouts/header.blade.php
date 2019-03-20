<header id="site_header" @guest class="mobile_header" @endif>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar_left">
      <a href="{{ route('landing') }}" class="navbar_logo navbar_item" title="GroupCalendar">
        @materialicon('calendar-heart')
        <span>GroupCalendar</span>
      </a>
    </div>
    @auth
    <div class="navbar_right">
      
      <notification-display
        v-bind:user_id="currentUser.id"
        v-bind:notifications="notifications"
        v-bind:asset_url="asset_url"
      >
        <a href="{{ route('notifications.index') }}" class="navbar_item" title="Notifications Page">
          <span class="icon">@materialicon('bell')</span>
        </a>
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
      <a href="{{ route('login') }}" class="navbar_item navbar_item-show_mobile">Login</a>
      <a href="{{ route('demo') }}" class="navbar_item navbar_item-show_mobile">Try a Demo</a>
    </div>
    @endif
  </nav>
</header>