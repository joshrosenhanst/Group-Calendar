<header>
  <img src="{{ $group->avatar }}" alt="{{ $group->name }} Avatar">
</header>
<section>
  <h2>Upcoming Events</h2>
  @include('events.upcoming', ['events'=>$group->events()->upcoming()->limit(4)->get()])
</section>
<section>
  <h2>Latest Comments</h2>
  @include('comments.list', ['comments'=>$group->latest_comments()])
</section>