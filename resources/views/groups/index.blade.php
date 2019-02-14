@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
<article id="maincontent">
  {{ Breadcrumbs::render('groups.index') }}
  @each('components.group.summary', $groups, 'group')
</article>

@include('layouts.sidebar')
@endsection