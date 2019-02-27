@extends('layouts.landing')

@section('title', 'Group Events')

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

  <div class="tabs">
    <ul>
      <li class="tab_active"><a>
        <span class="icon">@materialicon('calendar-text')</span>
        <span>Upcoming Events</span>
      </a></li>
      <li><a>
        <span class="icon">@materialicon('calendar-clock')</span>
        <span>Past Events</span>  
      </a></li>
    </ul>
  </div>

    
  @foreach($monthly_upcoming_events as $month=>$monthly_events)
    <div class="card card-has_tabs">
      <div class="card_sub_header">
        <h1 class="sub_title">{{$month}} Events</h1>
      </div>

      @foreach($monthly_events as $event)
      <div class="event_summary">
        <div class="summary_header summary_header-background_image" style="background-image: url({{ asset($event->header) }})">&nbsp;</div>
        <div class="card_section summary_details">
          <div class="summary_date">
            <span class="day">{{ $event->start_date->format('D') }}</span>
            <span class="date">{{ $event->start_date->format('d') }}</span>
            <span class="month">{{ $event->start_date->format('M') }}</span>
          </div>
          <div class="summary_info">
            <a class="summary_name" href="{{ route('events.view', ['event'=>$event]) }}">{{ $event->name }}</a>
            <div class="summary_location"><span>{{ $event->start_time_subtext }}</span> · <span>Brooklyn, NY</span></div>
            <div class="summary_status">
              <span class="status_display">
                <span class="icon icon-full_size">@materialicon('account-question')</span><strong class="status">Pending</strong>
              </span> · <a href="{{ route('events.view', ['event'=>$event]) }}" class="update_status">Update My Status</a>
            </div>
          </div>
          <div class="summary_links">
            <a href="{{ route('events.view', ['event'=>$event]) }}" class="button button-link button-inverted">
              <span class="icon">@materialicon('calendar-text-outline')</span>
              <span>Details</span>
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endforeach

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