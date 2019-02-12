<div class="sidebar sidebar_has_avatar sidebar-no-header">
  <div class="sidebar_section sidebar_section-avatar">
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_avatar_name">{{ $group->name }}</a>

    <div class="sidebar_avatar_members">
      @if($group->users_count)
        <div class="members_list">
          @each('members.preview', $group->users->take(8), 'user')
        </div>
      @else
        <span class="empty">No Members</span>
      @endif
      <div class="section_countline">
        <span class="countline_display">{{ trans_choice('messages.member_count',$group->users_count) }}</span>
        <a class="countline_all_link" href="{{ route('groups.members', ['group'=>$group]) }}" class="view_all">view all</a>
      </div>
    </div>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.new') }}" class="sidebar_link">
      {{--plus sign icon / plus sign over calendar / plus sign inside rounded square--}}
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>New Event</span>
    </a>
    <a href="{{ route('groups.events', ['group'=>$group]) }}" class="sidebar_link">
      {{--calendar icon--}}
      <span class="icon">@materialicon('calendar-range')</span>
      <span>Group Events</span>
    </a>
  </div>
</div>