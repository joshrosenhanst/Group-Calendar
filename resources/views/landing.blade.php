@extends('layouts.externalwrapper')

@section('title', 'Plan and collaborate on events with your group.')

@section('content')

<main id="landing_hero">
  <div id="bg_tiles">
    <div class="tile"></div>
    <div class="tile"></div>
    <div class="tile"></div>
    <div class="tile"></div>
    <div class="tile"></div>
  </div>
  @include("layouts.header_external")

  <section class="hero">
    <div class="hero_body">
      <h1 class="hero_title">Plan and collaborate on events with your group</h1>

      <div class="hero_subtitle">GroupCalendar helps you organize your friends, colleagues, movie lovers, concert goers, and everyone in between into private groups so that you can plan upcoming events together.</div>

      <a href="/demo" class="button button-large button-link">Try a Demo</a>
    </div>
    <div class="hero_image screen_sample">
      <div class="tablet_wrapper">
        <img src="{{ asset('img/event_sample2.jpg') }}" alt="GroupCalendar sample on tablet">
      </div>
    </div>
  </section>
</main>

@endsection