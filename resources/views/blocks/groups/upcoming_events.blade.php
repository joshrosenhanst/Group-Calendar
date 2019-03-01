<div class="card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('calendar')</span>
      <span>Upcoming Events</span>
    </h2>
    <a href="{{ route('groups.events.index', ['group'=>$group]) }}" class="button">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>View All Events</span>
    </a>
  </div>
  <div class="card_section upcoming_events_section">
    @if(count($events))
      @foreach($events as $event)
        @include('blocks.events.summary', ['event'=>$event,'mini'=>true])
      @endforeach
    @else
      @component('components.empty', ['icon'=>'calendar-question'])
        No Upcoming Events
      @endcomponent
    @endif
  </div>
</div>