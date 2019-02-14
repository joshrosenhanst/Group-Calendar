<div class="event_summary">
  <a class="summary_header" href="{{ route('events.view', ['event', $event]) }}">
    <img src="{{ asset($event->header) }}" alt="{{ $event->name }} header image">
  </a>
  <div class="summary_details">
    <div class="summary_date">
      <span class="day">{{ $event->summary_date->format('D') }}</span>
      <span class="date">{{ $event->summary_date->format('d') }}</span>
      <span class="month">{{ $event->summary_date->format('M') }}</span>
    </div>
    <div class="summary_info">
      <a class="summary_name" href="{{ route('events.view', ['event', $event]) }}">{{ $event->name }}</a>
    </div>
  </div>
</div>