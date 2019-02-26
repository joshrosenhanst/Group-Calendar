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
        startDate: '2019-02-10',
        endDate: '2019-02-12',
      },
      {
        title: 'Event 2',
        startDate: '2019-02-22'
      },
    ],
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