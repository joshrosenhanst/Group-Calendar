@extends('layouts.pagewrapper')

@section('title', 'My Events')

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.index') }}

      <h1 class="title">
        <span class="icon">@materialicon('calendar-text')</span>
        <span>@lang('pages.events.index.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.events.index.subtitle')</div>
    
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
  </div>

  {{-- Tab navigation --}}
  <nav class="tabs" is="tab-wrapper"    
    v-bind:tab-items="tabs"
    v-on:select-tab="selectTab"
  >
    {{--Noscript: graceful fallback by manually rendering the tabs--}}
    <ul slot="noscript">
      <li
      @if(request('tab') === NULL || request('tab') === 'upcoming_events')
        class="tab_active"
      @endif
      >
        <a href="{{ route('events.index', ['tab'=>'upcoming_events']) }}">
          <span class="icon">@materialicon('calendar-text')</span>
          <span>Upcoming Events</span>
        </a>
      </li>
      <li
      @if(request('tab') === 'past_events')
        class="tab_active"
      @endif
      >
        <a href="{{ route('events.index', ['tab'=>'past_events']) }}">
          <span class="icon">@materialicon('calendar-clock')</span>
          <span>Past Events</span>  
        </a>
      </li>
    </ul>
  
    {{-- TabWrapper tabs (only visible if JS is running) --}}
    <template slot="upcoming_events" style="display:none;">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>Upcoming Events</span>
    </template>
    <template slot="past_events" style="display:none;">
      <span class="icon">@materialicon('calendar-clock')</span>
      <span>Past Events</span>  
    </template>
  </nav>

  {{--Tab 1: Upcoming Events Tab--}}
  <div
    v-show="(activeTab === 'upcoming_events')"
    v-bind:class="{ 'active_tab': (activeTab === 'upcoming_events') }"

    @if(request('tab') === 'upcoming_events')
    class="tab upcoming_events_tab active_tab"
    @elseif(request('tab') === 'past_events')
    class="tab upcoming_events_tab"
    @elseif(request('tab') === NULL)
    class="tab upcoming_events_tab default_tab"
    @endif
  >
    <div class="card card-has_tabs">

      @if(count($monthly_upcoming_events))
        @foreach($monthly_upcoming_events as $month=>$monthly_events)
            <div class="card_sub_header">
              <h1 class="sub_title">{{$month}} Events</h1>
            </div>

            @foreach($monthly_events as $event)
              @include('blocks.events.summary', [
                'event'=>$event,
                'group'=>Auth::user()->groups->firstWhere("id",$event->group_id),
                'showGroup'=>true
              ])
            @endforeach
        @endforeach
      @else
          <div class="card_section">
            @component('components.empty', ['icon'=>'calendar-question'])
              No Upcoming Events
            @endcomponent
          </div>
      @endif
      
    </div>
  </div>

  {{--Tab 2: Past Events Tab--}}
  <div
    v-show="(activeTab === 'past_events')"
    v-bind:class="{ 'active_tab': (activeTab === 'past_events') }"

    @if(request('tab') === 'past_events')
    class="tab past_events_tab active_tab"
    @else
    class="tab past_events_tab"
    @endif
  >
    <div class="card card-has_tabs">
      
      @if(count($monthly_past_events))
        @foreach($monthly_past_events as $month=>$monthly_events)
          <div class="card_sub_header">
            <h1 class="sub_title">{{$month}} Events</h1>
          </div>
          
          @foreach($monthly_events as $event)
            @include('blocks.events.summary', [
              'event'=>$event,
              'group'=>Auth::user()->groups->firstWhere("id",$event->group_id),
              'showGroup'=>true
            ])
          @endforeach
        @endforeach
      @else
        <div class="card_section">
          @component('components.empty', ['icon'=>'calendar-question'])
            No Past Events
          @endcomponent
        </div>
      @endif

    </div>
  </div>

</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
  {{-- Home Sidebar --}}
  @include('layouts.sidebar.home')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

@section('page_scripts')
<script src="{{ asset(mix('/js/pages/events/index.js')) }}"></script>
@endsection