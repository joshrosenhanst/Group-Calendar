<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GroupCalendar | {{ $event->name }}</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/event_flyer.css') }}" />
</head>
<body>
  <main id="pdf_main">

    <header id="pdf_header">
      <a href="{{ route('landing') }}" class="header_logo" title="GroupCalendar">
        <img src="{{ asset('img/flyer/logo.png') }}" alt="GroupCalendar Logo">
      </a>
    </header>

    <section id="header_image" style="background-image: url({{ asset($event->header) }})">
    </section>

    <section id="event_details">
      <h1 id="event_title">{{ $event->name }}</h1>

      <div class="event_detail">
        <div class="event_icon">
          <img src="{{ asset('img/flyer/calendar.png') }}" alt="Calendar Icon">
        </div>
        <div class="detail_content">
          {{ $event->summary_date }}
        </div>
      </div>

      @if($event->location_place_id)
      {{-- Event Location --}}
      <div class="event_detail">
        <div class="event_icon">
          <img src="{{ asset('img/flyer/map-marker.png') }}" alt="Map Marker Icon">
        </div>
        <div class="detail_content">
          <div class="event_location_name">{{ $event->location_name }}</div>
          <div class="event_location_address">{{ $event->location_formatted_address }}</div>
        </div>
      </div>
      @endif

      {{-- Event Description --}}
      @isset($event->description)
      <div class="event_detail">
        <div class="event_icon">
          <img src="{{ asset('img/flyer/text.png') }}" alt="Text Icon">
        </div>
        <div class="detail_content" style="margin-bottom:0px;">
          {!! nl2br(e($event->description)) !!}
        </div>
      </div>
      @endisset

    </section>

    <section id="map_image">
      Map goes here
    </section>

    <footer id="pdf_footer"></footer>
  </main>
</body>
</html>