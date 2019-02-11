<div class="sidebar sidebar_has_avatar sidebar-no-header">
  <div class="sidebar_section sidebar_section-avatar" style="background-image:url('')">
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_name">{{ $group->name }}</a>
    <div class="sidebar_avatar_subtext">Created {{ $group->create_date }}</div>
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