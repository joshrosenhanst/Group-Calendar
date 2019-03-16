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
  <header id="pdf_header">
    <a href="{{ route('landing') }}" class="header_logo" title="GroupCalendar">
      <span class="icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" role="presentation" fill="#ff3860"><path d="M19,20V9H5V20H19M16,2H18V4H19C20.1,4 21,4.9 21,6V20C21,21.1 20.1,22 19,22H5C3.9,22 3,21.1 3,20V6C3,4.9 3.9,4 5,4H6V2H8V4H16V2M12,18.17L11.42,17.64C9.36,15.77 8,14.54 8,13.03C8,11.8 8.97,10.83 10.2,10.83C10.9,10.83 11.56,11.15 12,11.66C12.44,11.15 13.1,10.83 13.8,10.83C15.03,10.83 16,11.8 16,13.03C16,14.54 14.64,15.77 12.58,17.64L12,18.17Z"></path></svg>
      </span>
      <span>GroupCalendar</span>
    </a>
  </header>
  <main id="pdf_main">

    <header id="header_image" style="background-image: url({{ asset($event->header) }})">
    </header>

    <section id="event_details">
      <h1 id="event_title">{{ $event->name }}</h1>

      <div class="event_detail">
        <span class="icon icon-full_size">@materialicon('calendar')</span>
        <div class="detail_content">
          {{ $event->summary_date }}
        </div>
      </div>

      @if($event->location_place_id)
      {{-- Event Location --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('map-marker')</div>
        <div class="detail_content">
          <div class="event_location_name">{{ $event->location_name }}</div>
          <div class="event_location_address">{{ $event->location_formatted_address }}</div>
          @if($event->location_map_url)
          <a class="event_location_url" href="{{ $event->location_map_url }}" target="_blank">
            <span class="icon is-small">@materialicon('google-maps')</span>
            <span>Open Location in Google Maps</span>
          </a>
          @endif
        </div>
      </div>
      @endif

      {{-- Event Description --}}
      @isset($event->description)
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('text')</div>
        <div class="detail_content description">
          {{ $event->description }}
        </div>
      </div>
      @endisset

    </section>

    <section id="map_image">
      Map goes here
    </section>
  </main>
</body>
</html>