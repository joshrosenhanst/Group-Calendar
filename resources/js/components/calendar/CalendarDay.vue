<template>
  <div class="calendar_day"
    v-bind:class="dayClasses"
  >
    <div class="date_number"
      v-bind:class="{ today: this.isDayToday }"
    >
      {{ day.getDate() }}
    </div>
    <div class="date_events">
      <calendar-event
        v-for="(event, index) in relevantEvents"
        v-bind:key="index"
        v-bind:event="event"
        v-bind:starting="isSameDate(event.startDate, day)"
        v-bind:ending="isSameDate(event.endDate, day)"
      ></calendar-event>
    </div>
  </div>
</template>

<script>
//import { Day, Calendar, CalendarEvent, Functions as fn } from 'dayspan';
import CalendarMixin from './CalendarMixin.js';
import CalendarEvent from './CalendarEvent.vue';
export default {
  props: ['day','events','currentMonth'],
  components: {
    CalendarEvent
  },
  mixins: [CalendarMixin],
  computed: {
    isDayToday(){
      return this.isToday(this.day)
    },
    dayClasses(){
      return {
        'today': this.isDayToday,
        'out_calendar': !this.isSameMonth(this.day,this.currentMonth)
      };
    },
    /*
      relevantEvents() - return events that have the current calendar day between their start and end date.
    */
    relevantEvents(){
      return this.events.filter(event => this.isDayInEventRange(this.day,event));
    }
  }
}
</script>