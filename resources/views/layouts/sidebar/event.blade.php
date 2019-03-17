@can('edit', $event)
<div class="sidebar">
  
  <div class="sidebar_title">
    <h1 class="title">{{ $event->name }}</h1>
  </div>

  <div class="sidebar_section sidebar_links">
    <a href="{{ route('groups.events.edit', ['group'=>$event->group,'event'=>$event]) }}" class="sidebar_link">
      <span class="icon">@materialicon('pencil')</span>
      <span>Edit Event</span>
    </a>
    <a href="{{ route('groups.events.delete', ['group'=>$event->group,'event'=>$event]) }}" class="sidebar_link">
      <span class="icon">@materialicon('delete')</span>
      <span>Delete Event</span>
    </a>
  </div>
  
</div>
@endcan