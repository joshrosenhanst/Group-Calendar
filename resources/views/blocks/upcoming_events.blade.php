<div class="card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('calendar')</span>
      <span>{{ $title }}</span>
    </h2>
    <a href="{{ $events_route }}" class="button">
      <span class="icon">@materialicon('calendar-text')</span>
      <span>View All Events</span>
    </a>
  </div>
  <slider-carousel class="upcoming_events_section">
    <template>
      @if(count($events))
        @foreach($events as $event)
          @include('blocks.events.summary', [
            'event'=>$event,
            'mini'=>true,
            'show_group'=>$show_groups
          ])
        @endforeach
      @else
        @component('components.empty', ['icon'=>'calendar-question'])
          No Upcoming Events
        @endcomponent
      @endif
   </template>
  </slider-carousel>
  <div class="card_section slider">

    <button class="slider_button slider_prev" aria-label="Slide left"
      v-bind:click="$emit('slide-left')"
    >
      @materialicon('chevron-left')
    </button>

    <button class="slider_button slider_next" aria-label="Slide right"
      v-bind:click="$emit('slide-right')"
    >
      @materialicon('chevron-right')
    </button>

    <div class="slider_wrapper" ref="wrapper">

      <div class="upcoming_events_section slider_content">
        @if(count($events))
          @foreach($events as $event)
            @include('blocks.events.summary', [
              'event'=>$event,
              'mini'=>true,
              'show_group'=>$show_groups
            ])
          @endforeach
        @else
          @component('components.empty', ['icon'=>'calendar-question'])
            No Upcoming Events
          @endcomponent
        @endif
      </div>

    </div>

  </div>
</div>