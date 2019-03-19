@extends('layouts.externalwrapper')

@section('title', 'Page Not Found')

@section('content')
<main id="error_hero">
  <section class="error_page_content">
      <a href="{{ route('landing') }}" class="error_logo" title="GroupCalendar">
        <span class="icon logo_icon">@materialicon('calendar-heart')</span>
        <span>GroupCalendar</span>
      </a>
      <div class="error_icon">@materialicon('calendar-question')</div>
      <h1 class="error_title">Page Not Found</h1>
      <a href="{{ route('home') }}" class="button error_button">Return to the Home Page</a>
  </section>
</main>
@endsection