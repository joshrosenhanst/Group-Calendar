@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.view', $group) }}
    </div>

    {{-- Group Details --}}
    @include('components.group.summary', ['group'=>$group])
  </div>

  {{-- Upcoming Events --}}
  @include('blocks.upcoming_events', [
    'events'=>$events,
    'show_groups'=>false,
    'title'=>'Upcoming Events',
    'events_route' => route('groups.events.index', ['group'=>$group])
  ])

  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      {{-- Group Comments --}}
      <comments-card
        v-bind:comments="comments"
        v-bind:user="user"
        title="Group Comments"

        v-on:create-comment="createComment"
        v-on:update-comment="updateComment"
        v-on:delete-comment="deleteComment"
      ></comments-card>
    </div>
    <aside class="maincontent_aside">

      {{-- Recent Members --}}
      @include('blocks.groups.recent_members', [
        'members'=>$group->users->sortByDesc('created_at')->take(5) 
      ])
    </aside>
  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset('/js/pages/groups/view.js') }}"></script>
@endsection