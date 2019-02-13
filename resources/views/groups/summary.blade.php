<div class="group_summary card" style="background-image: url({{ asset($group->avatar) }})">
  <div class="card_section group_avatar_container">
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <div class="group_details">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_name">{{ $group->name }}</a>
      <div class="group_members_preview">
        @if($group->users_count)
          @each('members.preview_thumbnail', $group->users->take(12), 'user')
        @endif
      </div>
      <div class="group_subtext">{{ trans_choice('messages.member_count',$group->users_count) }} | Created {{ $group->create_date }}</div>
    </div>
    <div class="group_links">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="button button-link button-inverted">View Group</a>
    </div>
  </div>
</div>