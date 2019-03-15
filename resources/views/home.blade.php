@extends('layouts.pagewrapper')

@section('title', 'GroupCalendar Home')

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      
      <h1 class="title">
        <span class="icon">@materialicon('home')</span>
        <span>@lang('pages.home.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.home.subtitle')</div>

      @if(session('status'))
        <status-alert class="alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <strong>Note: </strong> {{ session('status') }}
        </status-alert>
      @endif

    </div>
  </div>

  @demo
  <status-alert class="alert-info" icon="alert-circle">
    <strong>Demo Mode: </strong> Demo user accounts can create and attend events but they can't join or leave groups. Email notifications are also disabled in Demo Mode.
  </status-alert>
  @enddemo

  @include('blocks.upcoming_events', [
    'title' => 'My Upcoming Events',
    'events_route' => route('events.index'),
    'events' => Auth::user()->upcoming_events
  ])

  <div class="card card-has_header">  
    <div class="card_header">
      <h2>
        <span class="icon">@materialicon('account-group')</span>
        <span>My Groups</span>
      </h2>
      @can('new',App\Group::class)
      <a href="{{ route('groups.new') }}" class="button">
        <span class="icon">@materialicon('plus-circle')</span>
        <span>Create New Group</span>
      </a>
      @endcan
    </div>
    {{-- List of Groups --}}
    @if(Auth::user()->groups->count())

      @foreach(Auth::user()->groups as $group)
        @component('components.group.summary', ['group'=>$group, 'mini'=>true])
          @slot('links')
          <div class="group_links">
            <a href="{{ route('groups.view', ['group'=>$group]) }}" class="button button-link button-inverted">
              <span class="icon">@materialicon('account-group')</span>
              <span>Group Home Page</span>
            </a>
          </div>
          @endslot
        @endcomponent
      @endforeach

    @else
      <div class="card_section">
        @component('components.empty', ['icon'=>'account-question'])
          <div>No Groups</div>
          <div class="sub_text">You do not belong to any groups. Groups are invite only.</div>
        @endcomponent
      </div>
    @endif

  </div>
  
</article>

<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Home Sidebar --}}
  @include('layouts.sidebar.home')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection