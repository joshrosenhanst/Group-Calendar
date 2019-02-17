<div class="card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('calendar-range')</span>
      <span>Upcoming Events</span></h2>
  </div>
  <div class="card_section upcoming_events_section">
    @each('blocks.events.summary', $events, 'event', 'blocks.events.empty')
  </div>
</div>