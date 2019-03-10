<template>
  <div class="datepicker"
    :class="{ 'datepicker-inline': inline }"
  >
    <app-dropdown aria-label="Datepicker dropdown"
      v-if="!isMobile || inline"
      ref="dropdown"
      :inline="inline"
    >
      <input
        v-if="!inline"
        ref="input"
        slot="trigger"
        autocomplete="off"
        class="form_input"
        type="text"
        :value="formatValue(dateSelected)"
        :disabled="disabled"
        :readonly="!editable"
        :min="minDate"
        :max="maxDate"
        :name="input_name"
        :id="input_id"
        :placeholder="input_placeholder"
        :aria-label="input_label"
        :class="input_class"
        @change.native="onChange($event.target.value)"
        @focus="$emit('focus', $event)"
        @blur="$emit('blur', $event)"
      >

      <template slot="dropdown_items" :disabled="disabled">

        <header class="datepicker_header">
          <button class="datepicker_chevron" aria-label="Previous Month"
            v-bind:class="{ 'is-disabled': prevMonthDisabled }"
            v-on:click.prevent="prevMonth"
            v-on:@keydown.enter.prevent="prevMonth"
            v-on:keydown.space.prevent="prevMonth"
          >
            <material-icon name="chevron-left" class="icon-full_size"></material-icon>
          </button>

          <span class="header_current_month">{{monthDisplay}}</span>

          <button class="datepicker_chevron" aria-label="Next Month"
            v-bind:class="{ 'is-disabled': nextMonthDisabled }"
            v-on:click.prevent="nextMonth"
            v-on:@keydown.enter.prevent="nextMonth"
            v-on:keydown.space.prevent="nextMonth"
          >
            <material-icon name="chevron-right" class="icon-full_size"></material-icon>
          </button>
        </header>

        <datepicker-table
          v-model="dateSelected"
          :day-names="dayNames"
          :month-names="monthNames"
          :first-day-of-week="firstDayOfWeek"
          :min-date="parsedMinDate"
          :max-date="parsedMaxDate"
          :focused="focusedDateData"
          :disabled="disabled"
          :unselectable-dates="unselectableDates"
          :selectable-dates="selectableDates"
          :events="events"
          :date-creator="dateCreator"
          @close="$refs.dropdown.isActive = false"
        ></datepicker-table>

      </template>
    </app-dropdown>

    <input
      v-else
      ref="input"
      slot="trigger"
      autocomplete="off"
      class="form_input"
      type="date"
      :value="formatValue(dateSelected)"
      :disabled="disabled"
      :min="parsedMinDate"
      :max="parsedMaxDate"
      :name="input_name"
      :id="input_id"
      :placeholder="input_placeholder"
      :aria-label="input_label"
      :class="input_class"
      @change.native="onChange($event.target.value)"
      @focus="$emit('focus', $event)"
      @blur="$emit('blur', $event)"
    >
  </div>
</template>

<script>
  import { isMobile } from './utils.js';

  import DatepickerTable from './DatepickerTable.vue';

  export default {
    components: {
      DatepickerTable,
    },
    props: {
      value: String,
      firstDayOfWeek: {
        type: Number,
        default: 0
      },
      input_name: {
        type: String,
        required: false
      },
      input_id: {
        type: String,
        required: false
      },
      input_class: {
        type: String,
        required: false
      },
      input_label: {
        type: String,
        required: false
      },
      input_placeholder: {
        type: String,
        required: false
      },
      inline: Boolean,
      minDate: String,
      maxDate: String,
      focusedDate: Date,
      editable: Boolean,
      disabled: Boolean,
      unselectableDates: Array,
      selectableDates: Array,
      dateFormatter: {
          type: Function,
          default: (date) => {
            const yyyyMMdd = date.getFullYear() +
                '/' + (date.getMonth() + 1) +
                '/' + date.getDate()
            const d = new Date(yyyyMMdd);
            return d.toLocaleDateString();
          }
      },
      dateParser: {
          type: Function,
          default: (date) => {
            return date ? new Date(Date.parse(date)) : new Date();
          }
      },
      dateCreator: {
          type: Function,
          default: () => {
            return new Date();
          }
      },
      mobileNative: {
        type: Boolean,
        default: true
      },
      position: String,
      events: Object
    },
    data() {
      const focusedDate = this.dateParser(this.value) || this.focusedDate || this.dateCreator();

      return {
        dayNames: ['Su','M','Tu','W','Th','F','S'],
        monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
        dateSelected: this.dateParser(this.value),
        focusedDateData: {
          date: new Date(focusedDate),
          month: focusedDate.getMonth(),
          year: focusedDate.getFullYear()
        },
        _elementRef: 'input',
        _isDatepicker: true,
        parsedMinDate: (this.minDate ? this.dateParser(this.minDate) : null),
        parsedMaxDate: (this.maxDate ? this.dateParser(this.maxDate) : null),
        prevMonthDisabled: false,
        nextMonthDisabled: false
      };
    },
    computed: {
      monthDisplay() {
        return this.monthNames[this.focusedDateData.month] + ' ' + this.focusedDateData.year;
      },
      isMobile() {
        return this.mobileNative && isMobile.any()
      }
    },
    watch: {
        /*
        * Emit input event with selected date as payload, set isActive to false.
        * Update internal focusedDateData
        */
        dateSelected(value) {
          const currentDate = !value ? this.dateCreator() : value;
          this.focusedDateData = {
            date: new Date(currentDate),
            month: currentDate.getMonth(),
            year: currentDate.getFullYear()
          };
          this.$emit('input', value);
          if (this.$refs.dropdown) {
            this.$refs.dropdown.isActive = false;
          }
        },

        /**
         * When v-model is changed: Update internal value.
         */
        value(value) {
          this.dateSelected = value;
        },

        focusedDate(value) {
          if (value) {
            this.focusedDateData = {
              date: value,
              month: value.getMonth(),
              year: value.getFullYear()
            }
          }
        },

        /*
        * Emit input event on month and/or year change
        */
        'focusedDateData.month'(value) {
          this.$emit('change-month', value)
        },
        'focusedDateData.year'(value) {
          this.$emit('change-year', value)
        }
    },
    methods: {
      /*
      * Emit input event with selected date as payload for v-model in parent
      */
      updateSelectedDate(date) {
        this.dateSelected = date;
      },

      /*
      * Parse string into date
      */
      onChange(value) {
        const date = this.dateParser(value);
        if (date && !isNaN(date)) {
          this.dateSelected = date;
        } else {
          // Force refresh input value when not valid date
          this.dateSelected = null;
          this.$refs.input.newValue = this.dateSelected;
        }
      },

      /*
      * Format date into string
      */
      formatValue(value) {
        if (value && !isNaN(value)) {
            return this.dateFormatter(value)
        } else {
            return null
        }
      },
      
      isPrevMonthAvailable(){
        if(this.parsedMinDate){
          let testDate = new Date(this.focusedDateData.date);
          testDate.setMonth(testDate.getMonth() - 1);
          
          return ( testDate > this.parsedMinDate );
        }else{
          return true;
        }
      },
      
      isNextMonthAvailable(){
        if(this.parsedMaxDate){
          let testDate = new Date(this.focusedDateData.date);
          testDate.setMonth(testDate.getMonth() + 1);
          
          return ( testDate < this.parsedMaxDate );
        }else{
          return true;
        }
      },

      prevMonth() {
        if (this.disabled) return

        if(this.isPrevMonthAvailable()){
          this.focusedDateData.date.setMonth(this.focusedDateData.date.getMonth() - 1);
          this.focusedDateData.month = this.focusedDateData.date.getMonth();
          this.focusedDateData.year = this.focusedDateData.date.getFullYear();
        }

        this.prevMonthDisabled = !this.isPrevMonthAvailable();
        this.nextMonthDisabled = !this.isNextMonthAvailable();
      },

      /*
      * Either increment month by 1 if not December or increment year by 1
      * and set month to 0 (January)
      */
      nextMonth() {
        if (this.disabled) return

        if(this.isNextMonthAvailable()){
          this.focusedDateData.date.setMonth(this.focusedDateData.date.getMonth() + 1);
          this.focusedDateData.month = this.focusedDateData.date.getMonth();
          this.focusedDateData.year = this.focusedDateData.date.getFullYear();
        }

        this.prevMonthDisabled = !this.isPrevMonthAvailable();
        this.nextMonthDisabled = !this.isNextMonthAvailable();
      },

      /*
      * Format date into string 'YYYY-MM-DD'
      */
      formatYYYYMMDD(value) {
        const date = new Date(value)
        if (value && !isNaN(date)) {
            const year = date.getFullYear()
            const month = date.getMonth() + 1
            const day = date.getDate()
            return year + '-' +
                ((month < 10 ? '0' : '') + month) + '-' +
                ((day < 10 ? '0' : '') + day)
        }
        return ''
      },

      /*
      * Parse date from string
      */
      onChangeNativePicker(event) {
        const date = event.target.value
        this.dateSelected = date ? new Date(date.replace(/-/g, '/')) : null
      }
    }
  }
</script>
