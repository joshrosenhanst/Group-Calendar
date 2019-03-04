<div class="event_mini_card">
  <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}" class="mini_header" style="background-image: url({{ asset($event->header) }})">
    <div class="mini_date">
      <div class="month">{{ $event->start_date->format('M') }}</div>
      <div class="date">{{ $event->start_date->format('d') }}</div>
    </div>
  </a>
  <div class="mini_details">
    <a class="mini_name" href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}">{{ $event->name }}</a>
    <div class="mini_location">Brooklyn, NY</div>
  </div>
</div>