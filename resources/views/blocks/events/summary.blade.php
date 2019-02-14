<div class="event-summary">
  <img src="{{ asset($event->header) }}" alt="{{ $event->name }} header image">
  <a class="event_name" href="{{ route('events.view', ['event', $event]) }}">{{ $event->name }}</a>
  <div>{{ $event->summary_date }}</div>
</div>