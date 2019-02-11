<div class="sidebar sidebar_has_avatar sidebar-no-header">
  <div class="sidebar_section sidebar_section-avatar">
    <a href="{{ route('profile.index') }}" class="sidebar_avatar_image">
      <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
    </a>
    <a href="{{ route('profile.index') }}" class="sidebar_avatar_name">{{ Auth::user()->name }}</a>
    <div class="sidebar_avatar_subtext">Joined {{ Auth::user()->join_date }}</div>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.calendar') }}" class="sidebar_link">My Calendar</a>
    <a href="{{ route('groups.index') }}" class="sidebar_link">My Profile</a>
    <a href="{{ route('notifications.index') }}" class="sidebar_link">Notifications</a>
    <a href="{{ route('logout') }}" class="sidebar_link">Log Out</a>
  </div>
</div>