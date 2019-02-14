@extends('layouts.landing')

@section('title', 'New Event')

@section('content')
<article id="maincontent">
  {{ Breadcrumbs::render('events.new') }}
  <form action="{{ route('events.create') }}" id="event_form" class="form card">
      @method('PUT')
      @csrf
      New form
  </form>
</article>
@include('layouts.sidebar')
@endsection