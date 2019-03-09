@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.view', $group) }}
    
      @if(session('status'))
        <status-alert class="alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <strong>Note: </strong> {{ session('status') }}
        </status-alert>
      @endif
      
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
        'members'=>$group->users
      ])
    </aside>
  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset('/js/pages/groups/view.js') }}"></script>
@endsection