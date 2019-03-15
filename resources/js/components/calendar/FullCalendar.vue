<template>
  <div class="full_calendar"
    v-bind:class="{ 'mini_calendar': mini }"
  >
    <header class="calendar_header">
      <button class="calendar_chevron" aria-label="Previous Month"
        v-on:click="prevMonth"
      >
        <material-icon name="chevron-left" class="icon-full_size"></material-icon>
      </button>
      <span class="current_month">{{monthDisplay}}</span>
      <button class="calendar_chevron" aria-label="Next Month"
        v-on:click="nextMonth"
      >
        <material-icon name="chevron-right" class="icon-full_size"></material-icon>
      </button>
    </header>
    <calendar-month
      v-bind:current-month="defaultedShowDate"
      v-bind:events="events"
    ></calendar-month>
  </div>
</template>

<script>
import CalendarMixin from './CalendarMixin.js';
import CalendarMonth from './CalendarMonth.vue';
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
    events: Array,
    mini: {
      type: Boolean,
      default: false
    }
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
      return this.getFormattedMonthNames( this.locale,( this.mini?"short":"long" ) );
    },
    monthDisplay(){
      return this.formattedPeriod(this.currentMonth, this.currentMonth, "month", this.monthNames)
    }
  }
}
</script>
