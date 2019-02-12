<div class="sidebar sidebar_has_avatar sidebar-no-header">
  <div class="sidebar_section sidebar_section-avatar">
    <a href="{{ route('profile.index') }}" class="sidebar_avatar_image">
      <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
    </a>
    <a href="{{ route('profile.index') }}" class="sidebar_avatar_name">{{ Auth::user()->name }}</a>
    <div class="sidebar_avatar_subtext">Joined {{ Auth::user()->join_date }}</div>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.calendar') }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar')</span>
      <span>My Calendar</span>
    </a>
    <a href="{{ route('groups.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('account')</span>
      <span>My Profile</span>
    </a>
    <a href="{{ route('notifications.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('bell')</span>
      <span>Notifications</span>
    </a>
    <a href="{{ route('logout') }}" class="sidebar_link">
      <span class="icon">@materialicon('logout')</span>
      <span>Log Out</span>
    </a>
  </div>
</div>