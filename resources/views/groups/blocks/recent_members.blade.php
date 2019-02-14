<div class="card card_members_list">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Recent Members</span>
    </h2>
  </div>
  <div class="card_section card_list">
    @include('members.list', ['users'=>$group->users->sortByDesc('created_at')->take(5)])
  </div>
  <div class="card_section card_buttons">
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button button-text">View All Members</a>
  </div>
</div>