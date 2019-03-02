<div class="sidebar">
  <div class="sidebar_header sidebar_header-no_content"></div>
  <div class="sidebar_header">
    <h1 class="title">
      <span class="preview_thumbnail">
        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
      </span>
      <span>{{ Auth::user()->name }}</span>
    </h1>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar')</span>
      <span>My Calendar</span>
    </a>
    <a href="{{ route('groups.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('account-group')</span>
      <span>My Groups</span>
    </a>
    <a href="{{ route('notifications.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('bell')</span>
      <span>Notifications</span>
    </a>
    <a href="{{ route('profile.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('account-box')</span>
      <span>My Profile</span>
    </a>
    <a href="{{ route('logout') }}" class="sidebar_link">
      <span class="icon">@materialicon('logout')</span>
      <span>Log Out</span>
    </a>
  </div>
  <div class="sidebar_footer sidebar_footer-no_content"></div>
</div>