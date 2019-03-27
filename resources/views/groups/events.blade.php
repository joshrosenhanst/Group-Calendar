@extends('layouts.pagewrapper')

@section('title', 'Group Events')

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.index', $group) }}

      <h1 class="title">
        <span class="icon">@materialicon('calendar-text')</span>
        <span>@lang('pages.groups.events.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.groups.events.subtitle')</div>
    
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

  <nav class="tabs" is="tab-wrapper"    
    v-bind:tab-items="tabs"
    v-on:select-tab="selectTab"
  >
    {{--Noscript: graceful fallback by manually rendering the tabs--}}
    <div class="tabs" slot="noscript">
      <div class="tablist" role="tablist">

        <a href="{{ route('groups.events.index', ['group'=>$group, 'tab'=>'upcoming_events']) }}" role="tab" tabindex="0"
          @if(request('tab') === NULL || request('tab') === 'upcoming_events')
            class="tab tab-active"
          @else
            class="tab"
          @endif
        >
          <span class="icon">@materialicon('calendar-text')</span>
          <span>Upcoming Events</span>
        </a>

        <a href="{{ route('groups.events.index', ['group'=>$group, 'tab'=>'past_events']) }}" role="tab" tabindex="0"
          @if(request('tab') === 'past_events')
            class="tab tab-active"
          @else
            class="tab"
          @endif
        >
          <span class="icon">@materialicon('calendar-clock')</span>
          <span>Past Events</span>  
        </a>
      </div>
    </div>
    
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
              'group'=>$group,
              'showGroup'=>false
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
              'group'=>$group,
              'showGroup'=>false
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
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

@section('page_scripts')
<script src="{{ asset(mix('/js/pages/groups/events.js')) }}"></script>
@endsection