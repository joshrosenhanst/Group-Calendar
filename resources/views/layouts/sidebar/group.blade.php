<div class="sidebar sidebar_has_avatar sidebar-no-header">
  <div class="sidebar_section sidebar_section-avatar">
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_name">{{ $group->name }}</a>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.new') }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>New Event</span>
    </a>
    <a href="{{ route('events.index', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-range')</span>
      <span>Group Events</span>
    </a>
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Group Members</span>
    </a>
  </div>
</div>