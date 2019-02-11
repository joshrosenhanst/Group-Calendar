<aside id="sidebar">
  <div class="sidebar sidebar-no-header">
    <div class="sidebar_section sidebar_links">
      <a href="{{ route('events.calendar') }}" class="sidebar_link">Home</a>
      <a href="{{ route('events.calendar') }}" class="sidebar_link">My Calendar</a>
      <a href="{{ route('groups.index') }}" class="sidebar_link">My Groups</a>
    </div>
  </div>
  @isset($group_selected)
    @include('layouts.sidebar.groups.display', ['groups'=>$group_selected])
  @else
    @include('layouts.sidebar.groups.list', ['groups'=>Auth::user()->groups])
  @endisset
  <div class="sidebar">
    <div class="sidebar_card">
      <div class="sidebar_header">
        <h1>My Profile</h1>
      </div>
      <div class="sidebar_section sidebar_links">
        <a href="{{ route('profile.index') }}" class="sidebar_link">View Profile</a>
        <a href="{{ route('notifications.index') }}" class="sidebar_link">Notifications</a>
        <a href="{{ route('logout') }}" class="sidebar_link">Log Out</a>
      </div>
    </div>
  </div>
</aside>