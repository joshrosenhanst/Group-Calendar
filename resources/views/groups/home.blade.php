@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent" class="card">
  <header>
    <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
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