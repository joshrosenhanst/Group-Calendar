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
      <app-dropdown
        class="navbar_dropdown"
        aria-label="Notifications dropdown" title="Notifications"
        trigger_classes="navbar_item navbar_item-icon has_badge"
        url="{{ route('notifications.index') }}"
      >
        <template slot="trigger">

          @if(Auth::user()->all_unread_notifications->count())
          <span class="badge">{{ Auth::user()->all_unread_notifications->count() }}</span>
          @endif
          
          <span class="icon">@materialicon('bell')</span>
        </template>

        <template slot="dropdown_items">
          @include('partials.notifications', [
            'notifications'=>Auth::user()->all_unread_notifications->take(5)
          ])
        </template>
      </app-dropdown>
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