<template>
    <section class="datepicker_month">
        <header class="week_header">
            <div
                v-for="(day, index) in visibleDayNames"
                :key="index"
                class="week_header_day">
                {{ day }}
            </div>
        </header>
        <div class="datepicker_weeks">
            <datepicker-table-row
                v-for="(week, index) in weeksInThisMonth(focused.month, focused.year)"
                :key="index"
                :selected-date="value"
                :week="week"
                :month="focused.month"
                :min-date="minDate"
                :max-date="maxDate"
                :disabled="disabled"
                :unselectable-dates="unselectableDates"
                :selectable-dates="selectableDates"
                :events="eventsInThisWeek(week, index)"
                :date-creator="dateCreator"
                @select="updateSelectedDate"/>
        </div>
    </section>
</template>

<script>
    import DatepickerTableRow from './DatepickerTableRow.vue'

    export default {
        components: {
          DatepickerTableRow
        },
        props: {
            value: Date,
            dayNames: Array,
            monthNames: Array,
            firstDayOfWeek: Number,
            events: Object,
            minDate: Date,
            maxDate: Date,
            focused: Object,
            disabled: Boolean,
            dateCreator: Function,
            unselectableDates: Array,
            selectableDates: Array
        },
        computed: {
            visibleDayNames() {
                const visibleDayNames = []
                let index = this.firstDayOfWeek
                while (visibleDayNames.length < this.dayNames.length) {
                    const currentDayName = this.dayNames[(index % this.dayNames.length)]
                    visibleDayNames.push(currentDayName)
                    index++
                }
                return visibleDayNames
            },

            hasEvents() {
                return this.events && this.events.length
            },

            /*
            * Return array of all events in the specified month
            */
            eventsInThisMonth() {
                if (!this.events) return {}

                const monthEvents = {};

                Object.keys(this.events).forEach((date) => {
                    let event_date = new Date(date);
                    if(event_date.getMonth() === this.focused.month && event_date.getFullYear() === this.focused.year){
                        monthEvents[date] = this.events[date];
                    }
                });

                return monthEvents
            }
        },
        methods: {
            /*
            * Emit input event with selected date as payload for v-model in parent
            */
            updateSelectedDate(date) {
                this.$emit('input', date)
            },

            /*
            * Return array of all days in the week that the startingDate is within
            */
            weekBuilder(startingDate, month, year) {
                const thisMonth = new Date(year, month)

                const thisWeek = []

                const dayOfWeek = new Date(year, month, startingDate).getDay()

                const end = dayOfWeek >= this.firstDayOfWeek
                    ? (dayOfWeek - this.firstDayOfWeek)
                    : ((7 - this.firstDayOfWeek) + dayOfWeek)

                let daysAgo = 1
                for (let i = 0; i < end; i++) {
                    thisWeek.unshift(new Date(
                        thisMonth.getFullYear(),
                        thisMonth.getMonth(),
                        startingDate - daysAgo)
                    )
                    daysAgo++
                }

                thisWeek.push(new Date(year, month, startingDate))

                let daysForward = 1
                while (thisWeek.length < 7) {
                    thisWeek.push(new Date(year, month, startingDate + daysForward))
                    daysForward++
                }

                return thisWeek
            },

            /*
            * Return array of all weeks in the specified month
            */
            weeksInThisMonth(month, year) {
                const weeksInThisMonth = []
                const daysInThisMonth = new Date(year, month + 1, 0).getDate()

                let startingDay = 1

                while (startingDay <= daysInThisMonth + 6) {
                    const newWeek = this.weekBuilder(startingDay, month, year)
                    let weekValid = false

                    newWeek.forEach((day) => {
                        if (day.getMonth() === month) {
                            weekValid = true
                        }
                    })

                    if (weekValid) {
                        weeksInThisMonth.push(newWeek)
                    }

                    startingDay += 7
                }

                return weeksInThisMonth
            },

            eventsInThisWeek(week, index) {
                let monthlyDates = Object.keys(this.eventsInThisMonth);
                if (!monthlyDates.length) return {}

                const weekEvents = {}

                let weeksInThisMonth = []
                weeksInThisMonth = this.weeksInThisMonth(this.focused.month, this.focused.year)

                for (let d = 0; d < weeksInThisMonth[index].length; d++) {

                    monthlyDates.forEach((date) => {
                        let event_date = new Date(date);
                        if(event_date.getTime() === weeksInThisMonth[index][d].getTime()){
                            weekEvents[date] = this.events[date];
                        }
                    });
                    /*for (let e = 0; e < this.eventsInThisMonth.length; e++) {
                        let event_date = new Date(this.eventsInThisMonth[e].date + " 00:00");
                        const eventsInThisMonth = event_date.getTime()
                        if (eventsInThisMonth === weeksInThisMonth[index][d].getTime()) {
                            weekEvents.push(this.eventsInThisMonth[e])
                        }
                    }*/
                }

                return weekEvents
            }
        }
    }
</script>
