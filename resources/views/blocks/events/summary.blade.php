{{-- Event Summary template --}}
<div class="event_summary {{ ($mini ? 'card event_summary-mini':'') }}">

    {{-- Date (displays DAY/DATE/MONTH in vertical lines )--}}
    <div class="summary_date">
      <span class="day">{{ $event->start_date->format('D') }}</span>
      <span class="date">{{ $event->start_date->format('d') }}</span>
      <span class="month">{{ $event->start_date->format('M') }}</span>
    </div>

    <div class="summary_info">

      {{-- Event Name --}}
      <a class="summary_name" href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}">{{ $event->name }}</a>

      {{-- Event Location and Start Time --}}
      <div class="summary_location">
        @if($mini || !$event->start_time_subtext)
        <span>Brooklyn, NY</span>
        @else
        <span>{{ $event->start_time_subtext }}</span> · <span>Brooklyn, NY</span>
        @endif
      </div>

      @if(!$mini)
      {{-- Show user status with relevant icon and link to change status | large card only --}}
      <div class="summary_status">
        <strong class="status_display {{ $event->user_status }}">@lang('status.attendee.'.$event->user_status)
        </strong> · <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}" class="update_status">Change My Status</a>
      </div>
      @endif
    </div>

    @if(!$mini)
    {{-- Event links | large card only --}}
    <div class="summary_links">
      <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}" class="button button-link button-inverted">
        <span class="icon">@materialicon('calendar-text-outline')</span>
        <span>Details</span>
      </a>
    </div>
    @endif

</div>