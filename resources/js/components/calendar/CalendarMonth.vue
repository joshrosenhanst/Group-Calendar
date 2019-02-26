<template>
  <div class="calendar_month">

    <div class="week_header calendar_week">
      <div class="week_header_day calendar_day"
        v-for="(weekday) in weekdays"
        v-bind:key="weekday"
      >{{weekday}}</div>
    </div>
		<div class="calendar_weeks">
			<calendar-week
				v-for="(week, index) in weeksOfMonth"
				v-bind:key="index"
				v-bind:days="daysOfWeek(week)"
				v-bind:events="getWeekEvents(week)"
				v-bind:current-month="currentMonth"
			></calendar-week>
		</div>
  </div>
</template>

<script>
import CalendarMixin from './CalendarMixin.js';
import CalendarWeek from './CalendarWeek.vue';
export default {
  props: {
    currentMonth: Date,
		events: Array
  },
  mixins: [CalendarMixin],
  components: {
    CalendarWeek
  },
  data: function(){
    return {
      weekdays: ['Sun','Mon','Tues','Wed','Thurs','Fri','Sat'],
      displayPeriodCount: 1,
      startingDayOfWeek: 0
    };
  },
  computed: {
    periodStart() {
			return this.beginningOfPeriod(this.currentMonth,"month",0)
		},
		periodEnd() {
			return this.addDays(
				this.incrementPeriod(this.periodStart,"month",this.displayPeriodCount),-1
			)
		},
    displayFirstDate() {
			return this.beginningOfWeek(this.periodStart, this.startingDayOfWeek)
		},
		displayLastDate() {
			return this.endOfWeek(this.periodEnd, this.startingDayOfWeek)
		},
    weeksOfMonth(){
      const numWeeks = Math.floor(
        (this.dayDiff( this.displayFirstDate, this.displayLastDate ) + 1) / 7
      );
      return Array(numWeeks).fill().map( (val, i) => this.addDays(this.displayFirstDate, i*7));
    },
    fixedEvents() {
			const self = this
			return this.events.map(event =>
				self.normalizeEvent(event)
			)
		},
  },
  methods: {
    findAndSortEventsInWeek(weekStart) {
			// Return a list of events that INCLUDE any day of a week starting on a
			// particular day. Sorted so the events that start earlier are always
			// shown first.
			const events = this.fixedEvents
				.filter(
					event =>
						event.startDate < this.addDays(weekStart, 7) &&
						event.endDate >= weekStart,
					this
				)
				.sort((a, b) => {
					if (a.startDate < b.startDate) return -1
					if (b.startDate < a.startDate) return 1
					if (a.endDate > b.endDate) return -1
					if (b.endDate > a.endDate) return 1
					return a.id < b.id ? -1 : 1
				})
			return events;
		},
    getWeekEvents(weekStart) {
			// Return a list of events that CONTAIN the week starting on a day.
			// Sorted so the events that start earlier are always shown first.
			const events = this.findAndSortEventsInWeek(weekStart)
			const results = []
			const eventRows = [[], [], [], [], [], [], []]
			for (let i = 0; i < events.length; i++) {
				const ep = Object.assign({}, events[i], {
					classes: [...events[i].classes],
					eventRow: 0,
				})
				const continued = ep.startDate < weekStart
				const startOffset = continued
					? 0
					: this.dayDiff(weekStart, ep.startDate)
				const span = Math.min(
					7 - startOffset,
					this.dayDiff(this.addDays(weekStart, startOffset), ep.endDate) + 1
				)
				if (continued) ep.classes.push("continued")
				if (this.dayDiff(weekStart, ep.endDate) > 6)
					ep.classes.push("toBeContinued")
				if (this.isInPast(ep.endDate)) ep.classes.push("past")
				if (ep.originalEvent.url) ep.classes.push("hasUrl")
				for (let d = 0; d < 7; d++) {
					if (d === startOffset) {
						let s = 0
						while (eventRows[d][s]) s++
						ep.eventRow = s
						eventRows[d][s] = true
					} else if (d < startOffset + span) {
						eventRows[d][ep.eventRow] = true
					}
				}
				ep.classes.push(`offset${startOffset}`)
				ep.classes.push(`span${span}`)
				results.push(ep)
			}
			return results
		},
  }
}
</script>