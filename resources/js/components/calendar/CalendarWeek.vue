<template>
  <div class="calendar_week">
    <calendar-day
      v-for="(day, index) in days"
      v-bind:key="index"
      v-bind:day="day"
      v-bind:events="events"
      v-bind:current-month="currentMonth"
    ></calendar-day>
  </div>
</template>

<script>
import CalendarDay from './CalendarDay.vue';
export default {
  props:{
    days: Array,
    events: Array,
    currentMonth: Date
  },
  components: {
    CalendarDay
  }
}
</script>

<style lang="sass" scoped>
.calendar_week
  display: flex
  flex: 1
  border-top: 1px solid #ccc
</style>
