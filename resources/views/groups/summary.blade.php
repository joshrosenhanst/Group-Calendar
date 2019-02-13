<div class="group-summary card card_has_avatar">
  <div class="card_section card_section-avatar">
    <a href="{{ route('groups.view', [$group]) }}" class="card_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="card_avatar_name">{{ $group->name }}</a>

    <div class="card_avatar_members">
      @if($group->users_count)
        <div class="members_list">
          @each('members.preview_thumbnail', $group->users->take(8), 'user')
        </div>
      @else
        <span class="empty">No Members</span>
      @endif
      <div class="card_countline">
        <span class="countline_display">{{ trans_choice('messages.member_count',$group->users_count) }}</span>
        <a class="countline_all_link" href="{{ route('groups.members', ['group'=>$group]) }}" class="view_all">view all</a>
      </div>
    </div>
  </div>
</div>