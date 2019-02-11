<div class="sidebar">
  <div class="sidebar_header">
    <h1>{{ $group->name }}</h1>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.new') }}" class="sidebar_link">New Event</a>
    <a href="{{ route('groups.events', ['group'=>$group]) }}" class="sidebar_link">Group Events</a>
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="sidebar_link">Group Members</a>
  </div>
</div>