<template>
<div class="calendar_event_container">
  <a class="calendar_event"
    v-if="details.link"
    v-bind:href="details.link"
    v-bind:class="eventClasses"
  >
    <template v-if="calEvent.starting">
      <span class="event_name">{{ details.title }}</span>
    </template>
    <span v-else>&nbsp;</span>
  </a>
  <span class="calendar_event" v-else 
    v-bind:class="eventClasses"
  >
    <template v-if="calEvent.starting">
      <span class="event_name">{{ details.title }}</span>
    </template>
    <span v-else>&nbsp;</span>
  </span>
</div>

</template>

<script>
import { CalendarEvent } from 'dayspan';
export default {
  props: {
    calEvent: CalendarEvent
  },
  computed: {
    details() {
      return {
        'title': this.calEvent.event.data.title,
        'link': this.calEvent.event.data.link,
        'start_time': this.calEvent.start.format('h:mm A'),
        'end_time': this.calEvent.end.format('h:mm A')
      };
    },
    eventClasses(){
      return {
        'starting': this.calEvent.starting && !this.calEvent.ending,
        'full_width': !this.calEvent.starting && !this.calEvent.ending,
        'ending': this.calEvent.ending && !this.calEvent.starting
      };
    }
  },
  mounted(){
    console.log("calEvent",this.calEvent,this.calEvent.start.format('[start:] MM-DD-YY h:mm a'),this.calEvent.end.format('[end:] MM-DD-YY h:mm a'));
  }
}
</script>

<style lang="sass" scoped>
.calendar_event_container
  position: relative
  height: 20px
  margin-top: 1px
.calendar_event
  background-color: rgb(63, 81, 181)
  color: #fff
  padding: 1px
  overflow: hidden
  text-overflow: ellipsis
  white-space: nowrap
  padding-left: 2px
  font-size: 11px
  position: absolute
  user-select: none
  display: block
  margin: 0
  border-radius: 2px
  left: 0
  right: 0
  top: 0
  &.starting
    right: -6px
  &.ending
    left: -6px
  &.full_width
    left: -6px
    right: -6px
.event_name
  font-weight: bold
</style>
