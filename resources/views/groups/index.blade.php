@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
<article id="maincontent">
  <div class="card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.index') }}
      <h1 class="title">My Groups</h1>
    </div>
    @each('components.group.summary',$groups,'group')
  </div>
</article>

@include('layouts.sidebar')
@endsection