<header>
  <img src="{{ $group->avatar }}" alt="{{ $group->name }} Avatar">
</header>
<section>
  <h2>Upcoming Events</h2>
  @each('events.summary', $group->events()->upcoming()->limit(4)->get(), 'event', 'events.empty')
</section>
<section>
  <h2>Latest Comments</h2>
</section>