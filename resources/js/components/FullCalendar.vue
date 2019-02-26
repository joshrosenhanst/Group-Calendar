<template>
  <div class="full_calendar">
    <header class="calendar_header">
      <button class="button" v-on:click="prevMonth">Prev Month</button>
      <span class="current_month">{{monthDisplay}}</span>
      <button class="button" v-on:click="nextMonth">Next Month</button>
    </header>
    <calendar-month
      v-bind:current-month="defaultedShowDate"
      v-bind:events="events"
    ></calendar-month>
  </div>
</template>

<script>
import CalendarMixin from './calendar/CalendarMixin.js';
import CalendarMonth from './calendar/CalendarMonth.vue';
export default {
  data: function(){
    return {
      currentMonth: new Date(),
    }
  },
  mixins: [CalendarMixin],
  components: {
    CalendarMonth
  },
  props: {
    events: Array
  },
  methods: {
    setMonth(month){
      this.currentMonth = month;
    },
    prevMonth() {
      this.setMonth( this.changeMonth(this.currentMonth, -1) );
    },
    nextMonth() {
      this.setMonth( this.changeMonth(this.currentMonth, 1) );
    }
  },
  computed: {
    locale(){
      return this.getDefaultBrowserLocale();
    },
    defaultedShowDate() {
			if (this.currentMonth) return this.dateOnly(this.currentMonth);
			return this.today();
    },
    monthNames(){
      return this.getFormattedMonthNames(this.locale,"long");
    },
    monthDisplay(){
      return this.formattedPeriod(this.currentMonth, this.currentMonth, "month", this.monthNames)
    }
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
