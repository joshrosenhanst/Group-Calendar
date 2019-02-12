@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <header class="maincontent_header card" style="background-image: url({{ asset($group->avatar) }})">
    <div class="maincontent_avatar_container">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="maincontent_header_avatar">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </a>
      <div class="maincontent_header_details">
        <a href="{{ route('groups.view', ['group'=>$group]) }}" class="maincontent_header_name">{{ $group->name }}</a>
        <div class="maincontent_header_subtext">Created {{ $group->create_date }}</div>
      </div>
    </div>
  </header>
  <section class="card_halves">
    <div class="card card_events_list">
      <div class="card_header">
        <h1>Upcoming Events</h1>
      </div>
      <div class="card_section">
        @include('events.upcoming', ['events'=>$events])
      </div>
      <div class="card_section card_buttons">
        <a href="{{ route('groups.events', ['group'=>$group]) }}" class="button button-text">View All Group Events</a>
      </div>
    </div>

    <div class="card card_members_list">
      <div class="card_header">
        <h1>Recently Added Members</h1>
      </div>
      <div class="card_section card_list">
        @include('members.list', ['users'=>$group->users->sortByDesc('created_at')->take(5)])
      </div>
      <div class="card_section card_buttons">
        <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button button-text">View All Members</a>
      </div>
    </div>
  </section>
  <section class="card">
    <h2>Upcoming Events</h2>
  </section>
  <section class="card">
    <h2>Latest Comments</h2>
    @include('comments.list', ['comments'=>$comments])
  </section>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection