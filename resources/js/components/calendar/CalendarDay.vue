<template>
  <div class="calendar_day"
    v-bind:class="dayClasses"
  >
    <div class="date_number"
      v-bind:class="{ today: day.currentDay }"
    >
      {{ day.dayOfMonth }}
    </div>
    <div class="date_events">
      <cal-event
        v-for="(event, index) in day.events"
        v-bind:key="index"
        v-bind:cal-event="event"
      ></cal-event>
    </div>
  </div>
</template>

<script>
import { Day, Calendar, CalendarEvent, Functions as fn } from 'dayspan';
import CalEvent from './CalendarEvent.vue';
export default {
  props: {
    day: {
      required: true,
      type: Day
    }
  },
  components: {
    CalEvent
  },
  computed: {
    dayClasses(){
      return {
        'today': this.day.currentDay,
        'first_day': this.day.dayOfMonth === 1,
        'out_calendar': !this.day.inCalendar
      };
    }
  },
  mounted(){
    console.log(this.day.dayOfMonth, this.day.events);
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

