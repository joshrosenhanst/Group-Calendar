@extends('layouts.landing')

@section('title', 'Logged In')

@section('content')
@auth
<h1>Logged In!</h1>
@else 
<h1>Guest</h1>
@endauth
<a href="{{ route('logout') }}">Log Out</a>
@endsection