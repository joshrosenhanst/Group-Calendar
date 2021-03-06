<div class="sidebar">

  <div class="sidebar_title">
    <h1 class="title">
      <span class="preview_thumbnail">
        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
      </span>
      <span>{{ Auth::user()->name }}</span>
    </h1>
  </div>

  <div class="sidebar_section sidebar_links">
    <a href="{{ route('home') }}" class="sidebar_link">
      <span class="icon">@materialicon('home')</span>
      <span>Dashboard</span>
    </a>
    {{--Group Invites - check for number of invites--}}
    @if(Auth::user()->group_invites->count())
    <a href="{{ route('invitations') }}" class="sidebar_link">
      <span class="icon">@materialicon('email')</span>
      <span>Group Invites</span>
      <span class="badge">{{ Auth::user()->group_invites->count() }}</span>
    </a>
    @endif
    <a href="{{ route('groups.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('account-group')</span>
      <span>My Groups</span>
    </a>
    <a href="{{ route('events.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>My Events</span>
    </a>
    <a href="{{ route('notifications.index') }}" class="sidebar_link">
      <span class="icon">@materialicon('bell')</span>
      <span>Notifications</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="sidebar_link">
      <span class="icon">@materialicon('account-box')</span>
      <span>Edit Profile</span>
    </a>
    @can('check-demo', Auth::user())
    <a href="{{ route('profile.password') }}" class="sidebar_link">
      <span class="icon">@materialicon('lock')</span>
      <span>Change Password</span>
    </a>
    @endcan
    <a href="{{ route('logout') }}" class="sidebar_link">
      <span class="icon">@materialicon('logout')</span>
      <span>Log Out</span>
    </a>
  </div>
  
</div>