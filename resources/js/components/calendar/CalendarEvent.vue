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