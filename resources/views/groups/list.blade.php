@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
<article id="maincontent">
  @each('groups.summary', $groups, 'group')
</article>

@include('layouts.sidebar')
@endsection