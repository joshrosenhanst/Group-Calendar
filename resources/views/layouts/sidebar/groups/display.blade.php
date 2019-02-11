<div class="sidebar">
  <div class="sidebar_header">
    <h1>{{ $group->name }}</h1>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.new') }}" class="sidebar_link">
      {{--plus sign icon / plus sign over calendar / plus sign inside rounded square--}}
      <span>New Event</span>
    </a>
    <a href="{{ route('groups.events', ['group'=>$group]) }}" class="sidebar_link">
      {{--calendar icon--}}
      <span>Group Events</span>
    </a>
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="sidebar_link">
      {{--users icon--}}
      <span>Group Members</span>
    </a>
  </div>
</div>