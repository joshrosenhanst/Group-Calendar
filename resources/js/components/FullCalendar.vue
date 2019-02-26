<template>
  <div class="full_calendar">
    <header class="calendar_header">
      <button class="button" v-on:click="prevMonth">Prev Month</button>
      <span class="current_month">{{summary}}</span>
      <button class="button" v-on:click="nextMonth">Next Month</button>
    </header>
    <calendar-month
      v-bind:calendar="calendar"
    ></calendar-month>
  </div>
</template>

<script>
import { Calendar, Day, Parse, Functions as fn } from 'dayspan';
import CalendarMonth from './calendar/CalendarMonth.vue';

function dsMerge(target,source){
  if (!fn.isObject(target))
  {
    return source;
  }

  if (fn.isObject(source))
  {
    for (let prop in source)
    {
      let sourceValue = source[ prop ];

      if (prop in target)
      {
        dsMerge( target[ prop ], sourceValue );
      }
      else
      {
        target[ prop ] = sourceValue;
      }
    }
  }

  return target;
}

export default {
  props: {
    events: Array
  },
  components: {
    CalendarMonth
  },
  data: function(){
    return {
      calendar: Calendar.months(),
    };
  },
  computed: {
    summary(){
      return this.calendar.summary(false,false,false,false)
    }
  },
  methods: {
    /*dayClicked(day){
      console.log("day clicked", day);
    },
    eventClicked(event){
      console.log("event clicked", event);
    },*/
    prevMonth(){
      this.calendar.unselect().prev();
    },
    nextMonth(){
      this.calendar.unselect().next();
    },
    triggerChange(){
      this.$emit('change', {
        calendar: this.calendar
      });
    },
    createEvent(event){
      return Parse.event({
        schedule: {
          /*on: Day.fromDate(event.start),
          start: Day.fromDate(event.start),
          end: Day.fromDate(event.end)*/
          on: event.start_date,
          duration: event.duration,
          durationUnit: 'days',
          times: [event.start_time, event.end_time]
        },
        data: dsMerge( {}, {
          title: event.title,
          link: event.link
        } )
      });
    },
    /*
      setCalendarEvents() - Add the `events` array to the dayspan Calendar object. Called whenever the `events` or `calendar` properties change (i.e if a new list of events is passed to the component or the calendar changes months).
    */
    setCalendarEvents(){
      if(this.events){
        this.calendar.removeEvents();
        for(let event of this.events){
          this.calendar.addEvent(
            this.createEvent(event)
          );
        }
      }
      //console.log(this.calendar);
    }
  },
  mounted() {
    console.log("FullCalendar mount", this.events);
    this.setCalendarEvents();
  },
  watch: {
    'events': 'setCalendarEvents',
    'calendar': 'setCalendarEvents',
  }
}
</script>

<style lang="sass" scoped>
.full_calendar
  position: relative
  border: 1px solid #ccc
.calendar_header
  display: flex
  justify-content: space-between
  align-items: center
  padding: 10px
  border-bottom: 1px solid #ccc
.current_month
  font-weight: bold
</style>
