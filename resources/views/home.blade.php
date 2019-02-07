@extends('layouts.landing')

@section('title', 'Home')

@section('content')
<a href="{{ route('logout') }}">Log Out</a>

@if(Auth::user()->groups()->count() === 1)
  @include('groups.home', ['group'=>Auth::user()->groups()->first()])
@else
  @include('groups.list', ['groups'=>Auth::user()->groups()->get()])
@endif
@endsection