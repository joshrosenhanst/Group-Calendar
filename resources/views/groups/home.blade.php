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
        <div class="maincontent_header_subtext">{{ $group->create_date }}</div>
      </div>
    </div>
  </header>
  <section>
    <h2>Upcoming Events</h2>
    @include('events.upcoming', ['events'=>$events])
  </section>
  <section>
    <h2>Latest Comments</h2>
    @include('comments.list', ['comments'=>$comments])
  </section>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection