{{-- Event Summary template --}}
<div class="event_summary">

  {{-- Date (displays DAY/DATE/MONTH in vertical lines )--}}
  <div class="summary_date">
    <span class="month">{{ $event->start_date->format('M') }}</span>
    <span class="date">{{ $event->start_date->format('d') }}</span>
  </div>

  <div class="summary_info">

    {{-- Event Name --}}
    <a class="summary_name" href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$group]) }}">{{ $event->name }}</a>

    {{-- Event Location and Start Time --}}
    <div class="summary_location">
      @if($event->start_time_subtext)
        <span>{{ $event->start_time_subtext }}</span>
        @if($event->city_state)
        · <span>{{ $event->city_state }}</span>
        @endif
      @elseif($event->city_state)
      <span>{{ $event->city_state }}</span>
      @endif
    </div>

    <div class="summary_extra">
      {{-- Group avatar + name (an additional $event->group query is skipped by having the parent view provide a $group variable) --}}
      @if($showGroup)
        <span class="summary_group">
          <span class="preview_thumbnail">
            <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
          </span>
          <strong>{{ $group->name }}</strong>
        </span>
      @endif

      {{-- Show user status with relevant icon and link to change status --}}
      <span class="summary_status">
        <strong class="status_display {{ $event->user_status }}">@lang('status.attendee.'.$event->user_status)
        </strong> · <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$group]) }}" class="update_status">Change My Status</a>
      </span>
    </div>
  </div>

  {{-- Event links --}}
  <div class="summary_links">
    <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$group]) }}" class="button button-link button-inverted">
      <span class="icon">@materialicon('calendar-text-outline')</span>
      <span>Details</span>
    </a>
  </div>

</div>