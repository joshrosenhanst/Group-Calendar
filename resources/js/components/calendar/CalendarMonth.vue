<template>
  <div class="calendar_month">

    <div class="week_header calendar_week">
      <div class="week_header_day calendar_day"
        v-for="(weekday, index) in weekdays"
        v-bind:key="weekday"
        v-bind:class="{ today: (today.dayOfWeek === index) }"
      >{{weekday}}</div>
    </div>

    <calendar-week
      v-for="i in rows"
      v-bind:key="i"
      v-bind:days="daysAtRow(i,7)"
    ></calendar-week>
  </div>
</template>

<script>
import { Calendar, CalendarEvent, Day } from 'dayspan';
import CalendarWeek from './CalendarWeek.vue';
export default {
  props: {
    calendar:{
      required: true,
      type: Calendar
    },
  },
  components: {
    CalendarWeek
  },
  data: function(){
    return {
      weekdays: ['Sun','Mon','Tues','Wed','Thurs','Fri','Sat'],
      today: Day.today()
    };
  },
  computed: {
    rows(){
      return Math.floor( this.calendar.days.length / 7);
    }
  },
  methods: {
    daysAtRow(row, rowSize){
      let start = (row-1)*rowSize;
      return this.calendar.days.slice(start,start+rowSize);
    }
  }
}
</script>

<style lang="sass" scoped>
.calendar_month
  width: 100%
  height: 100%
  display: flex
  flex-direction: column
  background-color: white
  .week_header
    display: flex
    flex: 1
    .week_header_day
      color: #757575
      flex: 1
      width: 0
      border-right: 1px solid #ccc
      padding: 4px
      overflow: hidden
      user-select: none
      text-align: center
      &.today
        color: #4285f4
        font-weight: 500
      &:last-of-type
        border-right: 0
</style>

