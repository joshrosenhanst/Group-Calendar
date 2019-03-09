@extends('layouts.landing')

@section('title', 'My Groups')

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.index') }}
      <h1 class="title">
        <span class="icon">@materialicon('account-group')</span>
        <span>@lang('pages.groups.index.title')</span>
      </h1>
      <div class="subtitle">@lang('pages.groups.index.subtitle')</div>
    </div>

    {{-- List of Groups --}}
    @foreach($groups as $group)
      @component('components.group.summary', ['group'=>$group])
        @slot('links')
        <div class="group_links">
          <a href="{{ route('groups.view', ['group'=>$group]) }}" class="button button-link button-inverted">
            <span class="icon">@materialicon('account-group')</span>
            <span>View</span>
          </a>
        </div>
        @endslot
      @endcomponent
    @endforeach

  </div>

</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Index Sidebar --}}
  @include('layouts.sidebar.groups')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection