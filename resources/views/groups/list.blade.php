@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
  @include('layouts.header')
  @each('groups.summary', $groups, 'group')
@endsection