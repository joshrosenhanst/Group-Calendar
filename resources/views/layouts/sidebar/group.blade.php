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
      <h2 class="section_headline">
        <span class="headline_text">{{ trans_choice('messages.member_count', ['count'=>$group->users_count]) }}</span>
        <a class="headline_sublink" href="{{ route('groups.members', ['group'=>$group]) }}" class="view_all">view all</a>
      </h2>
    </div>
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