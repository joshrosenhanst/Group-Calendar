<div class="card" id="attendees">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Attendees</span>
    </h2>
  </div>
  <div class="card_section card_list">
    @if(count($attendees))
      @foreach($attendees as $attendee)
        @include('blocks.attendees.list_item', ['user'=>$attendee])
      @endforeach
    @else
      @component('components.empty', ['icon'=>'account-question-outline','class'=>'list_empty'])
        No Attendees
      @endcomponent
    @endif
  </div>
</div>