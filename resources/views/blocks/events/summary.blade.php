{{-- Event Summary template --}}
<div class="event_summary {{ ($mini ? 'card':'') }}">
  {{-- Summary Header - img link for mini card, background header for large --}}
  @if($mini)
  <a class="summary_header" href="{{ route('events.view', ['event'=>$event]) }}">
    <img src="{{ asset($event->header) }}" alt="{{ $event->name }} header image">
  </a>
  @else
  <div class="summary_header summary_header-background_image" style="background-image: url({{ asset($event->header) }})">&nbsp;</div>
  @endif

  {{-- Details --}}
  <div class="card_section summary_details">
    {{-- Date (displays DAY/DATE/MONTH in vertical lines )--}}
    <div class="summary_date">
      <span class="day">{{ $event->start_date->format('D') }}</span>
      <span class="date">{{ $event->start_date->format('d') }}</span>
      <span class="month">{{ $event->start_date->format('M') }}</span>
    </div>

    <div class="summary_info">

      <a class="summary_name" href="{{ route('events.view', ['event'=>$event]) }}">{{ $event->name }}</a>

      <div class="summary_location">
        @if($mini)
        <span>Brooklyn, NY</span>
        @else
        <span>{{ $event->start_time_subtext }}</span> · <span>Brooklyn, NY</span>
        @endif
      </div>

      @if(!$mini)
      {{-- Show user status with relevant icon and link to change status | large card only --}}
      <div class="summary_status">
        <strong class="status_display">
          <span class="icon icon-full_size">@materialicon('account-question')</span> Pending
        </strong> · <a href="{{ route('events.view', ['event'=>$event]) }}" class="update_status">Update My Status</a>
      </div>
      @endif
    </div>

    @if(!$mini)
    {{-- Event links | large card only --}}
    <div class="summary_links">
      <a href="{{ route('events.view', ['event'=>$event]) }}" class="button button-link button-inverted">
        <span class="icon">@materialicon('calendar-text-outline')</span>
        <span>Details</span>
      </a>
    </div>
    @endif

  </div>

</div>