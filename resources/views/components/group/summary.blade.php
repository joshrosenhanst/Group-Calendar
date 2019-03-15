<div class="group_summary @if(isset($mini) && $mini) summary-mini @endif">
  <div class="card_section card_section-background_image" style="background-image: url({{ asset($group->header) }})"></div>
  <div class="card_section group_avatar_container">
    <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_avatar_image">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </a>
    <div class="group_details">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_name">
        {{ $group->name }}
      </a>

      <div class="group_subtext"><strong>{{ trans_choice('messages.member_count',$group->users_count) }}</strong> · Created {{ $group->create_date }}</div>

      <div class="group_subtext"><strong>{{ trans_choice('messages.upcoming_event_count',$group->upcoming_events->count()) }}</strong></div>

      @isset($subtext)
      {{ $subtext }}
      @endisset
    </div>
    @isset($links)
    {{ $links }}
    @endisset
  </div>
</div>