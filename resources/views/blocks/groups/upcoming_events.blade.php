<div class="card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('calendar-range')</span>
      <span>Upcoming Events</span></h2>
  </div>
  <div class="card_section upcoming_events_section">
    @each('blocks.events.summary', $events, 'event', 'blocks.events.empty')
  </div>
  <div class="card_section card_buttons">
    <a href="{{ route('groups.events.new', ['group'=>$group]) }}" class="button button-text">
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>Create New Event</span>
    </a>
    <a href="{{ route('groups.events', ['group'=>$group]) }}" class="button button-text">
      <span class="icon">@materialicon('calendar-range')</span>
      <span>View All Group Events</span>
    </a>
  </div>
</div>