@extends('layouts.landing')

@section('title', 'Calendar')

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{--breadcrumb--}}
    </div>

    <div class="card_calendar">
      <full-calendar
        v-bind:events="events"
        v-on:event-clicked="eventClicked"
        v-on:day-clicked="dayClicked"
      ></full-calendar>
    </div>
  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
    {{-- User Sidebar --}}
    @include('layouts.sidebar.user')
  </aside>
@endsection

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    events: [
      {
        title: 'Event 1',
        link: 'http://google.com/',
        start_date: '2019-02-10',
        duration: 0,
        start_time: '3:30',
        end_time: '4:30'
      },
      {
        title: 'Event 2',
        start_date: '2019-02-22',
        duration: 3,
        start_time: '3:30',
        end_time: '4:30'
      },
      {
        title: 'Event 3',
        start_date: '2019-02-22',
        duration: 0,
        start_time: '3:30',
        end_time: '4:30'
      },
      {
        title: 'Event 4',
        start_date: '2019-02-22',
        duration: 0,
        start_time: '3:30',
        end_time: '4:30'
      },
      {
        title: 'Event 5',
        start_date: '2019-02-22',
        duration: 0,
        start_time: '3:30',
        end_time: '4:30'
      },
    ]
  },
  mounted: function(){
    console.log("mount");
  },
  methods: {
    eventClicked: function(event){
      console.log("event click", event);
    },
    dayClicked: function(day){
      console.log("day clicked",day);
    }
  }
});
</script>
@endpush