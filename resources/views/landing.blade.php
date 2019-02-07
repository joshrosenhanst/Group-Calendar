@extends('layouts.landing')

@section('title', 'Plan and collaborate on events with your group.')

@section('content')
<main>
  @guest
  <a href="{{ route('login') }}">Login</a>
  @else
  <a href="{{ route('home') }}">Group Home</a>
  <a href="{{ route('logout') }}">Logout</a>
  @endguest
  <a href="{{ route('demo') }}">Try a Demo</a>
</main>
@endsection