@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
<article id="maincontent">
  @each('components.group.summary', $groups, 'group')
</article>

@include('layouts.sidebar')
@endsection