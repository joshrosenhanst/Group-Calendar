<template>
    <div class="datepicker_week">
        <template v-for="(day, index) in week">
            <a class="datepicker_day"
                v-if="selectableDate(day) && !disabled"
                :key="index"
                :class="[classObject(day), {'datepicker_day-has_events':weeklyEvents[index].length}]"
                role="button"
                href="#"
                :disabled="disabled"
                @click.prevent="emitChosenDate(day)"
                @keydown.enter.prevent="emitChosenDate(day)"
                @keydown.space.prevent="emitChosenDate(day)">
                {{ day.getDate() }}

                <div class="events_container" v-if="weeklyEvents[index].length">
                    <div class="day_event"
                        :style="{ 'background-color': event.color }"
                        v-for="(event, index) in weeklyEvents[index]"
                        :key="index"/>
                </div>
                <div class="day_event_tooltip" v-if="weeklyEvents[index].length">
                    <header class="event_tooltip_header">{{ day.toLocaleDateString() }} Events</header>
                    <ul>
                        <li 
                            v-for="(event,index) in weeklyEvents[index]"
                            :key="index"
                            :style="{ 'color': event.color }"
                        >
                            <span class="day_event_text">{{ event.summary }}</span>
                        </li>
                    </ul>
                </div>

            </a>
            <div
                v-else
                :key="index"
                :class="classObject(day)"
                class="datepicker_day">
                {{ day.getDate() }}
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            selectedDate: Date,
            week: {
                type: Array,
                required: true
            },
            month: {
                type: Number,
                required: true
            },
            minDate: Date,
            maxDate: Date,
            disabled: Boolean,
            unselectableDates: Array,
            selectableDates: Array,
            events: Object,
            dateCreator: Function
        },
        computed: {
            weeklyEvents(){
                return this.getWeeklyEvents(this.week);
            }
        },
        methods: {
            /*
            * Check that selected day is within earliest/latest params and
            * is within this month
            */
            selectableDate(day) {
                const validity = []

                if (this.minDate) {
                    validity.push(day >= this.minDate)
                }

                if (this.maxDate) {
                    validity.push(day <= this.maxDate)
                }

                //validity.push(day.getMonth() === this.month)

                if (this.selectableDates) {
                    for (let i = 0; i < this.selectableDates.length; i++) {
                        const enabledDate = this.selectableDates[i]
                        if (day.getDate() === enabledDate.getDate() &&
                            day.getFullYear() === enabledDate.getFullYear() &&
                            day.getMonth() === enabledDate.getMonth()) {
                            return true
                        } else {
                            validity.push(false)
                        }
                    }
                }

                if (this.unselectableDates) {
                    for (let i = 0; i < this.unselectableDates.length; i++) {
                        const disabledDate = this.unselectableDates[i]
                        validity.push(
                            day.getDate() !== disabledDate.getDate() ||
                            day.getFullYear() !== disabledDate.getFullYear() ||
                            day.getMonth() !== disabledDate.getMonth()
                        )
                    }
                }
                return validity.indexOf(false) < 0
            },

            /*
            * Emit select event with chosen date as payload
            */
            emitChosenDate(day) {
                if (this.disabled) return

                if (this.selectableDate(day)) {
                    this.$emit('select', day)
                }
            },

            getWeeklyEvents(week){
                let week_events = [];
                week.forEach((day,index)=>{
                    let daily_events = this.eventsDateMatch(day);
                    week_events[index] = daily_events;
                });
                return week_events;
            },

            eventsDateMatch(day) {
                let weekly_dates = Object.keys(this.events);
                if (!weekly_dates.length) return false

                let dayEvents = []

                weekly_dates.forEach((date) => {
                    let event_date = new Date(date);
                    if(event_date.getDay() === day.getDay()){
                        let todays_events = Object.values(this.events[date]);
                        dayEvents = todays_events;
                    }
                });
                
                return dayEvents;
            },

            /*
            * Build classObject for cell using validations
            */
            classObject(day) {
                function dateMatch(dateOne, dateTwo) {
                    // if either date is null or undefined, return false
                    if (!dateOne || !dateTwo) {
                        return false
                    }

                    return (dateOne.getDate() === dateTwo.getDate() &&
                        dateOne.getFullYear() === dateTwo.getFullYear() &&
                        dateOne.getMonth() === dateTwo.getMonth())
                }

                return {
                    'is-selected': dateMatch(day, this.selectedDate),
                    'is-today': dateMatch(day, this.dateCreator()),
                    'is-selectable': this.selectableDate(day) && !this.disabled,
                    'is-unselectable': !this.selectableDate(day) || this.disabled,
                    'out_calendar': (day.getMonth() !== this.month)
                }
            }
        }
    }
</script>
