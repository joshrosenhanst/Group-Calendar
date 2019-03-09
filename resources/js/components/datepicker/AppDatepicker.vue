<template>
  <div class="datepicker">
    <app-dropdown aria-label="Datepicker dropdown"
      v-if="!isMobile || inline"
      ref="dropdown"
    >
      <input
        v-if="!inline"
        ref="input"
        slot="trigger"
        autocomplete="off"
        class="form_input"
        type="date"
        :value="formatValue(dateSelected)"
        :placeholder="placeholder"
        :size="size"
        :icon="icon"
        :icon-pack="iconPack"
        :rounded="rounded"
        :loading="loading"
        :disabled="disabled"
        :readonly="!editable"
        :name="input.name"
        :id="input.id"
        :min="input.min"
        :max="input.max"
        :aria-label="input['aria-label']"
        :class="input.class"
        @change.native="onChange($event.target.value)"
        @focus="$emit('focus', $event)"
        @blur="$emit('blur', $event)"
      >

      <template slot="dropdown_items" :disabled="disabled">

        <header class="datepicker_header">
          <button class="header_chevron" aria-label="Previous Month"
            v-on:click.prevent="prevMonth"
            v-on:@keydown.enter.prevent="prevMonth"
            v-on:keydown.space.prevent="prevMonth"
          >
            <material-icon name="chevron-left" class="icon-full_size"></material-icon>
          </button>

          <span class="header_current_month">{{monthDisplay}}</span>

          <button class="header_chevron" aria-label="Next Month"
            v-on:click.prevent="nextMonth"
            v-on:@keydown.enter.prevent="nextMonth"
            v-on:keydown.space.prevent="nextMonth"
          >
            <material-icon name="chevron-right" class="icon-full_size"></material-icon>
          </button>
        </header>

        <div class="datepicker_content">
          <datepicker-table
            v-model="dateSelected"
            :day-names="dayNames"
            :month-names="monthNames"
            :first-day-of-week="firstDayOfWeek"
            :min-date="minDate"
            :max-date="maxDate"
            :focused="focusedDateData"
            :disabled="disabled"
            :unselectable-dates="unselectableDates"
            :selectable-dates="selectableDates"
            :events="events"
            :indicators="indicators"
            :date-creator="dateCreator"
            @close="$refs.dropdown.isActive = false"
          ></datepicker-table>
        </div>
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
      :placeholder="placeholder"
      :size="size"
      :icon="icon"
      :icon-pack="iconPack"
      :rounded="rounded"
      :loading="loading"
      :disabled="disabled"
      :readonly="!editable"
      :name="input.name"
      :id="input.id"
      :min="input.min"
      :max="input.max"
      :aria-label="input['aria-label']"
      :class="input.class"
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
      value: Date,
      firstDayOfWeek: {
          type: Number,
          default: 0
      },
      inline: Boolean,
      minDate: Date,
      maxDate: Date,
      focusedDate: Date,
      placeholder: String,
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
            return new Date(Date.parse(date));
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
      events: Array,
      indicators: {
        type: String,
        default: 'dots'
      }
    },
    data() {
      const focusedDate = this.value || this.focusedDate || this.dateCreator();

      return {
        dayNames: ['Su','M','Tu','W','Th','F','S'],
        monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
        dateSelected: this.value,
        focusedDateData: {
          month: focusedDate.getMonth(),
          year: focusedDate.getFullYear()
        },
        _elementRef: 'input',
        _isDatepicker: true
      };
    },
    computed: {
      monthDisplay() {
        return this.monthNames[this.focusedDateData.month] + this.focusedDateData.year;
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

      /*
      * Either decrement month by 1 if not January or decrement year by 1
      * and set month to 11 (December)
      */
      prevMonth() {
        if (this.disabled) return

        if (this.focusedDateData.month > 0) {
          this.focusedDateData.month -= 1
        } else {
          this.focusedDateData.month = 11
          this.focusedDateData.year -= 1
        }
      },

      /*
      * Either increment month by 1 if not December or increment year by 1
      * and set month to 0 (January)
      */
      nextMonth() {
        if (this.disabled) return

        if (this.focusedDateData.month < 11) {
          this.focusedDateData.month += 1
        } else {
          this.focusedDateData.month = 0
          this.focusedDateData.year += 1
        }
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
