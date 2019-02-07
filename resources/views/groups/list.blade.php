@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
  @each('groups.summary', $groups, 'group')
@endsection