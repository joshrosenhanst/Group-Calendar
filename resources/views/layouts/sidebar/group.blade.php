<div class="sidebar">
  <div class="sidebar_header sidebar_header-no_content"></div>
  <div class="sidebar_header">
    <h1 class="title">
      <span class="preview_thumbnail">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </span>
      <span>{{ $group->name }}</span>
    </h1>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('groups.events.new', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>New Event</span>
    </a>
    <a href="{{ route('groups.events.index', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>Group Events</span>
    </a>
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Members</span>
    </a>
    <a href="{{ route('groups.edit', ['group'=>$group]) }}" class="sidebar_link">
      <span class="icon">@materialicon('settings')</span>
      <span>Settings</span>
    </a>
  </div>
  <div class="sidebar_footer sidebar_footer-no_content"></div>
</div>