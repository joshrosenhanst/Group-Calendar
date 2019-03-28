@extends('layouts.pagewrapper')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.view', $group) }}
    
      @if(session('status'))
        <status-alert class="alert alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <div class="alert_text">
            <strong>Note: </strong> {{ session('status') }}
          </div>
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
        title="Group Comments"
        v-bind:comments="comments"
        v-bind:user="user"
        v-bind:user_admin="@json(Auth::user()->can('manageComments', $group))"
        v-bind:asset_url="asset_url"

        v-on:create-comment="createComment"
        v-on:update-comment="updateComment"
        v-on:delete-comment="deleteComment"
      >
        {{--Noscript: fallback to display the simple list of comments and comment form --}}
        @include('blocks.comments.list', [
          'comments' => $group->comments,
          'title' => 'Group Comments',
          'form_url' => route('groups.createComment', ['group'=>$group]),
          'errors' => $errors->all()
        ])
      </comments-card>
    </div>
    <aside class="maincontent_aside">

      {{-- Recent Members --}}
      @include('blocks.groups.recent_members', [
        'members'=>$group->users->sortByDesc('pivot.created_at')->take(6)
      ])
    </aside>
  </div>
</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset(mix('/js/pages/groups/view.js')) }}"></script>
@endsection