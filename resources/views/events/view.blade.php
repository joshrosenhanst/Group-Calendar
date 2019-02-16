@extends('layouts.landing')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.view', $event) }}
      <h1 class="title">{{ $event->name }}</h1>
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