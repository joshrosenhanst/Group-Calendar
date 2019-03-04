@extends('layouts.landing')

@section('title', 'Group Events')

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.index', $group) }}

      <h1 class="title">
        <span class="icon">@materialicon('calendar-range')</span>
        <span>@lang('pages.groups.events.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.groups.events.subtitle')</div>

      {{-- Session Status Alert --}}
      @include('partials.status_alert', [
        'color' => 'info',
        'body' => session('status')
      ])
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
      @if(count($monthly_upcoming_events))
        @foreach($monthly_upcoming_events as $month=>$monthly_events)
          <div class="card {{ $loop->first?'card-has_tabs':'' }}">
            @if(!$loop->first)
            <div class="card_header card_header-no_content"></div>
            @endif
            <div class="card_sub_header">
              <h1 class="sub_title">{{$month}} Events</h1>
            </div>

            @foreach($monthly_events as $event)
            @include('blocks.events.summary', ['event'=>$event,'mini'=>false])
            @endforeach
          </div>
        @endforeach
      @else
        <div class="card card-has_tabs">
          <div class="card_section">
            @component('components.empty', ['icon'=>'calendar-question'])
              No Upcoming Events
            @endcomponent
          </div>
        </div>
      @endif
      
  </div>

  <div class="tab past_events_tab" v-show="activeTab === 'past_events'">
    <div class="card_section">
      
      @if(count($monthly_past_events))
        @foreach($monthly_past_events as $month=>$monthly_events)
          <div class="card {{ $loop->first?'card-has_tabs':'' }}">
            @if(!$loop->first)
            <div class="card_header card_header-no_content"></div>
            @endif
            <div class="card_sub_header">
              <h1 class="sub_title">{{$month}} Events</h1>
            </div>

            @foreach($monthly_events as $event)
            @include('blocks.events.summary', ['event'=>$event,'mini'=>false])
            @endforeach
          </div>
        @endforeach
      @else
        <div class="card card-has_tabs">
          <div class="card_section">
            @component('components.empty', ['icon'=>'calendar-question'])
              No Past Events
            @endcomponent
          </div>
        </div>
      @endif

    </div>
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

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    tabs: ['upcoming_events','past_events'],
    activeTab: 'upcoming_events'
  },
  mounted: function(){
    console.log("mount");
  },
  methods: {
    selectTab(tab){
      this.activeTab = tab;
    }
  }
});
</script>
@endpush