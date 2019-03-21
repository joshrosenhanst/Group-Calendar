<div id="attendees" class="card card-has_header">

  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Attendees</span>
    </h2>
  </div>

  <div class="card_section card_list card_list-med">
    @if(count($attendees))
      @foreach($attendees as $attendee)

        <div class="list_item attendee_list_preview">
            @if($attendee)
            <a href="{{ route('users.view', ['user'=>$attendee]) }}" class="preview_thumbnail">
              <img src="{{ asset($attendee->avatar) }}" alt="{{ $attendee->name }} Avatar">
            </a>
            @else
            <span class="preview_thumbnail">
              <img src="{{ asset('img/default_user_avatar.jpg') }}" alt="Default User Avatar">
            </span>
            @endif

            <div class="preview_name">
              @if($attendee)
              <a href="{{ route('users.view', ['user'=>$attendee]) }}">{{ $attendee->name }}</a>
              @else
              <span class="attendee_default_name">Deleted User</span>
              @endif

              <small class="status {{ $attendee->pivot->status }}">{{ trans('status.attendee.'.$attendee->pivot->status) }}</small>
            </div>
        </div>

      @endforeach
    @else
      @component('components.empty', ['icon'=>'account-question-outline','class'=>'list_empty'])
        No Attendees
      @endcomponent
    @endif
  </div>
</div>