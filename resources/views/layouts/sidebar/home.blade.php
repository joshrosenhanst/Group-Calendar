
@can('new', \App\Event::class)
<div class="sidebar">
  
  <div class="sidebar_title">
    <h1 class="title">
      <span class="icon">@materialicon('home')</span>
      <span>Dashboard</span>
    </h1>
  </div>
    
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('events.new') }}" class="sidebar_link">
      <span class="icon">@materialicon('calendar-plus')</span>
      <span>New Event</span>
    </a>
  </div>
    
</div>
@endcan