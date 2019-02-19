@extends('layouts.landing')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.view', $event) }}
    </div>

    {{-- Event Details --}}
    <div class="card_section card_section-background_image" style="background-image:url({{ asset($event->header) }})"></div>
    <div class="card_section event_card_section-main">
      <h1 class="event_title">{{ $event->name }}</h1>
      <div class="event_date event_detail">
        <span class="icon icon-full_size">@materialicon('calendar')</span>
        <div class="detail_content">
          {{ $event->summary_date }}
        </div>
      </div>
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('map-marker')</div>
        <div class="detail_content">
          <a href="#">1256 Franklin St<small>Brooklyn, NY 07747</small></a>
        </div>
      </div>
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('account-group')</div>
        <div class="detail_content">
          <a href="#attendees">{{ $event->group->name }}
            <small class="seperated_count">
              @if($event->going_attendees_count)
                <span>{{ $event->going_attendees_count }} Going</span>
              @endif
              @if($event->interested_attendees_count)
               <span>{{ $event->interested_attendees_count }} Interested</span>
              @endif
            </small>
          </a>
        </div>
      </div>
      @if($user_status)
        <div class="event_detail">
          <div class="icon icon-full_size" aria-label="My Attendee Status">@materialicon(__('status.attendee.icon.'.$user_status))</div>
          <div class="detail_content">
            {{ __('status.attendee.'.$user_status) }}
            <small><a href="#attending">Change My Status</a></small>
          </div>
        </div>
      @else
        <div class="attend_buttons button_group" aria-label="Update My Attendee Status">
          <a href="{{ route('events.attend', ['event'=>$event,'status'=>'going'])}}" class="button button-link button-inverted">
            <span class="icon">@materialicon('check')</span>
            <span>Going</span>
          </a>
          <a href="{{ route('events.attend', ['event'=>$event,'status'=>'interested'])}}" class="button button-info button-inverted">
            <span class="icon">@materialicon('star')</span>
            <span>Interested</span>
          </a>
          <a href="{{ route('events.attend', ['event'=>$event,'status'=>'unavailable'])}}" class="button button-danger button-inverted">
            <span class="icon">@materialicon('close')</span>
            <span>Unavailable</span>
          </a>
          <a href="{{ route('events.attend', ['event'=>$event,'status'=>'pending'])}}" class="button button-danger button-inverted">
            <span class="icon">@materialicon('question')</span>
            <span>Pending</span>
          </a>
        </div>
      @endif
    </div>
    <div class="card_section event_card_section-description">
      <div class="description">
        {{ $event->description }}
      </div>
      <dl class="event_description_list">
        <div class="description_list_group">
          <dt>Created By</dt>
          <dd>
            <a href="{{ route('users.view', ['user'=>$event->creator]) }}">{{ $event->creator->name }}</a>
          </dd>
        </div>
        <div class="description_list_group">
          <dt>Event Link</dt>
          <dd>
            <a href="{{ route('events.view', ['event'=>$event]) }}">{{ route('events.view', ['event'=>$event]) }}</a>
          </dd>
        </div>
      </dl>
    </div>
  </div>

  {{-- Additional info cards --}}
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      {{-- Event Comments --}}
      @include('blocks.events.comments', ['comments'=>$event->comments])
    </div>
    <aside class="maincontent_aside">
      {{-- Event Attendees --}}
      @include('blocks.events.attendees', ['attendees'=>$event->attendees])
    </aside>
  </div>
</article>
@include('layouts.sidebar')
@endsection