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
        <status-alert class="alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <strong>Note: </strong> {{ session('status') }}
        </status-alert>
      @endif

    </div>
  </div>

  <tab-wrapper
    v-bind:tab-items="tabs"
    v-on:select-tab="selectTab"
  >
    <template slot="upcoming_events">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>Upcoming Events</span>
    </template>
    <template slot="past_events">
      <span class="icon">@materialicon('calendar-clock')</span>
      <span>Past Events</span>  
    </template>
  </tab-wrapper>

  <div class="tab upcoming_events_tab" v-show="activeTab === 'upcoming_events'">
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

  <div class="tab past_events_tab" v-show="activeTab === 'past_events'">
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
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Home Sidebar --}}
  @include('layouts.sidebar.home')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

@section('page_scripts')
<script src="{{ asset('/js/pages/events/index.js') }}"></script>
@endsection