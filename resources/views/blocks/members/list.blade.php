<div class="card_section card_list {{ count($members) ? 'card_list-mini' : '' }}">
  @if(count($members))
    @foreach($members as $member)
      <div class="list_item list_item-large_thumbnails">
        <a href="{{ route('users.view', ['user'=>$member]) }}"  class="preview_thumbnail">
          <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }} Avatar">
        </a>
        <div class="item_details">
          
            <a href="{{ route('users.view', ['user'=>$member]) }}"  class="preview_name">{{ $member->name }}</a>
            <div class="subtext">
              @if($type === "members")
                <strong class="capitalize">{{ $member->pivot->role }}</strong> · <span >Joined {{ $member->join_date }}</span>
              @else
                <span>Invited {{ $member->join_date }}</span>
              @endif
            </div>
        </div>
      </div>
    @endforeach
  @else
    @component('components.empty', ['icon'=>'account-question-outline','class'=>'list_empty'])
      {{ $empty_text }}
    @endcomponent
  @endif
</div>