@extends('layouts.landing')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.view', $event) }}
    </div>
    <div class="card_section card_section-background_image" style="background-image:url({{ asset($event->header) }})"></div>
    <div class="card_section event_card_section-main">
      <h1 class="event_title">{{ $event->name }}</h1>
      <div class="event_date event_detail">
        <div class="detail_icon">
          <span class="icon">@materialicon('calendar')</span>
        </div>
        <div class="detail_content">
          {{ $event->summary_date }}
        </div>
      </div>
      <div class="event_location">
        <a href="#location" class="button button-text">
          <span class="icon">@materialicon('map-marker')</span>
          <span>Brooklyn, NY</span>
        </a>
      </div>
      <div class="attend_buttons button_group">
        <a href="#" class="button button-link button-inverted">
          <span class="icon">@materialicon('check')</span>
          <span>Going</span>
        </a>
        <a href="#" class="button button-info button-inverted">
          <span class="icon">@materialicon('star')</span>
          <span>Interested</span>
        </a>
      </div>
    </div>
    <div class="card_section">
      <dl>
        <dt>Name</dt>
        <dd>{{ $event->name }}</dd>
        <dt>Group</dt>
        <dd><a href="{{ route('groups.view', ['group'=>$event->group]) }}">{{ $event->group->name }}</a></dd>
        <dt>Created By</dt>
        <dd>
          <a href="{{ route('users.view', ['user'=>$event->creator]) }}">{{ $event->creator->name }}</a>
        </dd>
        <dt>Description</dt>
        <dd>{{ $event->description }}</dd>
        <dt>Start Date</dt>
        <dd>
          {{ $event->start_date->format('l, F j, Y') }}
          @isset($event->start_time_subtext)
            <small>{{ $event->start_time_subtext }}</small>
          @endisset
        </dd>
        @isset($event->end_date)
          <dt>End Date</dt>
          <dd>
            {{ $event->end_date->format('l, F j, Y') }}
            @isset($event->end_time_subtext)
              <small>{{ $event->end_time_subtext }}</small>
            @endisset
          </dd>
        @endisset
      </dl>
    </div>
  </div>
</article>
@include('layouts.sidebar')
@endsection