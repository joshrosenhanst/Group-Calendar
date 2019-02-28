<div class="card card_members_list">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Recent Members</span>
    </h2>
  </div>
  <div class="card_section card_list">
    @if(count($members))
      @foreach($members as $member)
        @include('blocks.members.list_item', ['user'=>$member])
      @endforeach
    @else
      @component('components.empty', ['icon'=>'account-question-outline','class'=>'list_empty'])
        No Members
      @endcomponent
    @endif
  </div>
  <div class="card_section card_buttons">
    <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button button-text">View All Members</a>
  </div>
</div>