@extends('layouts.externalwrapper')

@section('title', 'Plan and collaborate on events with your group.')

@section('content')

<main id="maincontent" class="landing_hero">
  <div id="header_background" aria-hidden="true">
    <span class="tile">&nbsp;</span>
  </div>
  @include("layouts.header_external")

  <section class="hero">
    <div class="hero_body">
      <h1 class="hero_title">Plan and collaborate on events with your group</h1>

      <div class="hero_subtitle">GroupCalendar helps you organize your friends, colleagues, movie lovers, concert goers, and everyone in between into private groups so that you can plan upcoming events together.</div>

      <a href="{{ route('demo') }}" class="button button-large button-link">Try a Demo</a>
    </div>
    <div class="hero_image screen_sample">
      <div class="tablet_wrapper">
        <img src="{{ asset('img/event_sample.jpg') }}" alt="GroupCalendar sample on tablet">
      </div>
    </div>
  </section>
</main>

<section id="promos">

  <div class="promo_item">
    <div class="promo_image">
      <img src="{{ asset('img/datepicker_sample.png') }}" alt="Promotional Image - Datepicker">
    </div>
    <div class="promo_content">
      <h2 class="promo_title">Plan</h2>
      <div class="promo_info">
        GroupCalendar makes it easy to plan upcoming events with the calendar date selection tool that shows conflicting events in your other groups. 
      </div>
      <blockquote class="promo_quote">
        <p class="quote_text">"We can be heroes."</p>
        <footer class="quote_source">&mdash; David Bowie, on planning a costume party</footer>
      </blockquote>
    </div>
  </div>

  <div class="promo_item">
    <div class="promo_image">
      <img src="{{ asset('img/comments_sample.png') }}" alt="Promotional Image - Comments">
    </div>
    <div class="promo_content">
      <h2 class="promo_title">Collaborate</h2>
      <div class="promo_info">
        All group members can leave comments and set their attendance status on events. GroupCalendar also features robust notifications, so you can get quick feedback on your events.
      </div>
      <blockquote class="promo_quote">
        <p class="quote_text">"Stop, collaborate and listen."</p>
        <footer class="quote_source">&mdash; Vanilla Ice, on working together to plan great events</footer>
      </blockquote>
    </div>
  </div>

  <div class="promo_item">
    <div class="promo_image">
      <img src="{{ asset('img/header_selection_sample.jpg') }}" alt="Promotional Image - Commetns">
    </div>
    <div class="promo_content">
      <h2 class="promo_title">Customize</h2>
      <div class="promo_info">
        Make your event stand out with customizable header images and beautifully designed PDF flyers available for each event.
      </div>
      <blockquote class="promo_quote">
        <p class="quote_text">"Hey, Good Lookin'"</p>
        <footer class="quote_source">&mdash; Hank Williams, on finding the perfect look for an event</footer>
      </blockquote>
    </div>
  </div>

</section>

<section id="call_to_action">
  <div class="action_item">
    <h2>
      <span class="icon logo_icon">@materialicon('calendar-heart')</span>
      <span>Try GroupCalendar Today</span>
    </h2>
    <p>The Demo mode of GroupCalendar will log you into a random test account so that you can try out the app today. Demo accounts can create events, set their attendance status, and comment on events in their demo groups. Some functionality including email notifications are disabled for the demo.</p>
    <a href="{{ route('demo') }}" class="button button-link">Try a Demo</a>
  </div>
</section>

<footer id="landing_footer">
</footer>
@endsection