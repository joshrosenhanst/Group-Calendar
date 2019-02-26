<div class="card">
  <div class="card_header">
    <h2>
      <span>Upcoming Events</span>
    </h2>
    <a href="{{ route('groups.events', ['group'=>$group]) }}" class="button">
      <span class="icon">@materialicon('calendar-range')</span>
      <span>View All Events</span>
    </a>
  </div>
  <div class="card_section upcoming_events_section">
    @each('blocks.events.summary', $events, 'event', 'blocks.events.empty')
  </div>
</div>