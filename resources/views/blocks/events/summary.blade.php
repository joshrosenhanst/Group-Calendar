<div class="event_summary card">
  <a class="summary_header" href="{{ route('events.view', ['event', $event]) }}">
    <img src="{{ asset($event->header) }}" alt="{{ $event->name }} header image">
  </a>
  <div class="summary_details card_section">
    <div class="summary_date">
      <span class="day">{{ $event->start_date->format('D') }}</span>
      <span class="date">{{ $event->start_date->format('d') }}</span>
      <span class="month">{{ $event->start_date->format('M') }}</span>
    </div>
    <div class="summary_info">
      <a class="summary_name" href="{{ route('events.view', ['event', $event]) }}">{{ $event->name }}</a>
      <div class="summary_location">Brooklyn, NY</div>
    </div>
  </div>
  <div class="card_section card_buttons">
    <a href="{{ route('events.view', ['event', $event]) }}" class="button button-text button-small">View Event</a>
  </div>
</div>