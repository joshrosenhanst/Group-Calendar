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

<style lang="sass" scoped>
  .calendar_day
    flex: 1
    width: 0
    border-right: 1px solid #ccc
    padding: 4px
    overflow: hidden
    user-select: none
    min-height: 100px
    &:last-of-type
      border-right: 0
    &.out_calendar
      .date_number
        color: #757575


  .date_number
    text-decoration: none
    color: #212121
    width: 24px
    height: 24px
    line-height: 24px
    text-align: center
    user-select: none
    &:hover
      text-decoration: underline
    &.today 
      border-radius: 12px
      background-color: #4285f4
      color: white
      display: inline-block
      position: relative
      z-index: 1

  .date_events
    position: relative
</style>

