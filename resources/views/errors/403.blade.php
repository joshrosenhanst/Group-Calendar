@extends('layouts.externalwrapper')

@section('title', 'Not Authorized')

@section('content')
<main id="error_hero">
  <section class="error_page_content">
      <a href="{{ route('landing') }}" class="error_logo" title="GroupCalendar">
        <span class="icon logo_icon">@materialicon('calendar-heart')</span>
        <span>GroupCalendar</span>
      </a>
      <div class="error_icon">@materialicon('calendar-alert')</div>
      <h1 class="error_title">Not Authorized</h1>
      <div class="error_message">You do not have the permissions required to complete this action.</div>
      <a href="{{ route('home') }}" class="button error_button">Return to the Home Page</a>
  </section>
</main>
@endsection