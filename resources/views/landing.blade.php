@extends('layouts.landing')

@section('title', 'Plan and collaborate on events with your group.')

@section('content')
<main>
  <a href="{{ route('login') }}">Login</a>
  <a href="{{ route('demo') }}">Try a Demo</a>
</main>
@endsection