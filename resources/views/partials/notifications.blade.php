
<div class="dropdown_notifications">
  @if(count($notifications))
    @foreach($notifications as $notification)
    
      {{-- Open .dropdown_item Tag: either <div> or <a> --}}
      @isset($notification->data['url'])
      <a href="{{ $notification->data['url'] }}" class="dropdown_item">
      @else
      <div class="dropdown_item">
      @endisset

      {{-- Notification icon: defaults to `bell-alert` --}}
      <div class="icon">
        @isset($notification->data['icon'])
          @materialicon($notification->data['icon'])
        @else
          @materialicon('bell-alert')
        @endisset
      </div>
      
      {{-- Notification details: text + human readable created_at (ex 22 hours ago) --}}
      <div class="notification_details">
        <div class="text">{!! $notification->data['text'] !!}</div>
        <div class="subtext">{{ $notification->created_at->diffForHumans() }}</div>
      </div>

      {{-- Close Tag: either <div> or <a> --}}
      @isset($notification->data['url'])
      </a>
      @else
      </div>
      @endisset
      
    @endforeach
  @else
    <div class="empty list_empty">
      <span class="icon">@materialicon('bell-outline')</span>
      <h2>No Unread Notifications</h2>
    </div>
  @endif
</div>
<div class="dropdown_footer">
  <a href="{{ route('notifications.index') }}" class="button">View All Notifications</a>
</div>