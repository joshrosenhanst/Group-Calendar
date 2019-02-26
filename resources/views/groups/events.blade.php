@extends('layouts.landing')

@section('title', 'Calendar')

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events', $group) }}
      <h1 class="title">
        <span class="icon">@materialicon('calendar-range')</span>
        <span>@lang('pages.groups.events.title')</span>
      </h1>
      <div class="subtitle">@lang('pages.groups.events.subtitle')</div>
    </div>
  </div>

  <div class="maincontent_container">
    <div class="maincontent_events_section">
      list
    </div>
    <div class="maincontent_calendar_section">
      <full-calendar
        v-bind:events="events"
      ></full-calendar>
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
    events: @json($group->getCalendarEvents())
  },
  mounted: function(){
    console.log("mount");
  },
  methods: {

  }
});
</script>
@endpush