<div class="sidebar">
  
  <div class="sidebar_title">
    <h1 class="title">
      <span class="preview_thumbnail">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </span>
      <span>{{ $group->name }}</span>
    </h1>
  </div>

  <div class="sidebar_section sidebar_links">
    @can('newEvent', $group)
    <a href="{{ route('groups.events.new', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>New Event</span>
    </a>
    @endcan
    @can('events', $group)
    <a href="{{ route('groups.events.index', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>Group Events</span>
    </a>
    @endcan
    @can('members', $group)
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Members</span>
    </a>
    @endcan
    @can('edit', $group)
    <a href="{{ route('groups.edit', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('settings')</span>
      <span>Edit Group Settings</span>
    </a>
    @endcan
    @can('leave', $group)
    <a href="{{ route('groups.leave', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('account-remove')</span>
      <span>Leave Group</span>
    </a>
    @endcan
  </div>
  
</div>