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
          <a href="#attending">{{ $event->group->name }}<small>3 Going | 4 Interested</small></a>
        </div>
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
</article>
@include('layouts.sidebar')
@endsection