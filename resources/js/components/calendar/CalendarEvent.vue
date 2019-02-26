<template>
<div class="calendar_event_container">
  <a class="calendar_event"
    v-if="event.link"
    v-bind:href="event.link"
    v-bind:class="eventClasses"
  >
    <template v-if="starting">
      <span class="event_name">{{ event.title }}</span>
    </template>
    <span v-else>&nbsp;</span>
  </a>
  <span class="calendar_event" v-else 
    v-bind:class="eventClasses"
  >
    <template v-if="starting">
      <span class="event_name">{{ event.title }}</span>
    </template>
    <span v-else>&nbsp;</span>
  </span>
</div>

</template>

<script>
export default {
  props: {
    event: Object,
    starting: Boolean,
    ending: Boolean
  },
  computed: {
    eventClasses(){
      return {
        'starting': this.starting && !this.ending,
        'full_width': !this.starting && !this.ending,
        'ending': this.ending && !this.starting
      };
    }
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
