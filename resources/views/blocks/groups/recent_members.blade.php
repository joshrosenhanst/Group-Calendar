<div class="card card-has_header card_members_list">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Recent Members</span>
    </h2>
  </div>
  <div class="card_section card_list">
    @if(count($members))
      @foreach($members as $member)
        <div class="member_list_preview list_item">
          <a class="preview_thumbnail" href="{{ route('users.view', ['user'=>$member]) }}">
            <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }} Avatar">
          </a>
          <div class="preview_name">
            <a href="{{ route('users.view', ['user'=>$member]) }}">{{ $member->name }}</a>
            <small class="subtext">Joined {{ $member->join_date }}</small>
          </div>
        </div>
      @endforeach
    @else
      @component('components.empty', ['icon'=>'account-question-outline','class'=>'list_empty'])
        No Members
      @endcomponent
    @endif
  </div>
  <div class="card_buttons">
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>View All Members</span>
    </a>
  </div>
</div>