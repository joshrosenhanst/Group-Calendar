<div class="event_mini_card">
  <a href="{{ route('events.view', ['event'=>$event]) }}" class="mini_header" style="background-image: url({{ asset($event->header) }})">
    <div class="mini_date">
      <div class="month">{{ $event->start_date->format('M') }}</div>
      <div class="date">{{ $event->start_date->format('d') }}</div>
    </div>
  </a>
  <div class="mini_details">
    <a class="mini_name" href="{{ route('events.view', ['event'=>$event]) }}">{{ $event->name }}</a>
    <div class="mini_location">
      Brooklyn, NY
    </div>
  </div>
</div>