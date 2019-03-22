<template>
  <div class="datepicker"
    :class="{ 'datepicker-inline': inline, 'datepicker-active': isActive }"
  >
    <template v-if="!isMobile || inline">
      <input
        v-if="!inline"
        ref="input"
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
        @click.prevent="openCalendar"
        @input.capture="onInput($event)"
        @focus="openCalendar"
        @blur.prevent="onBlur"
        @keydown.enter.prevent="toggleCalendar"
        @keydown.space.prevent="toggleCalendar"
        @keydown.left.prevent="prevDay"
        @keydown.up.prevent="prevWeek"
        @keydown.right.prevent="nextDay"
        @keydown.down.prevent="nextWeek"
      >

      <div class="calendar_container" v-show="isActive" ref="calendar_container">
        <header class="datepicker_header">
          <a class="datepicker_chevron" aria-label="Previous Month"
            v-bind:class="{ 'is-disabled': prevMonthDisabled }"
            v-on:click.prevent="prevMonth"
            v-on:@keydown.enter.prevent="prevMonth"
            v-on:keydown.space.prevent="prevMonth"
            tabindex="-1"
          >
            <material-icon name="chevron-left" class="icon-full_size"></material-icon>
          </a>

          <span class="header_current_month">{{monthDisplay}}</span>

          <a class="datepicker_chevron" aria-label="Next Month"
            v-bind:class="{ 'is-disabled': nextMonthDisabled }"
            v-on:click.prevent="nextMonth"
            v-on:keydown.enter.prevent="nextMonth"
            v-on:keydown.space.prevent="nextMonth"
            tabindex="-1"
          >
            <material-icon name="chevron-right" class="icon-full_size"></material-icon>
          </a>
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
          :events="events"
          :date-creator="dateCreator"
          @input="onInput($event)"
        ></datepicker-table>

      </div>
    </template>
    <template v-else>
      <input
        ref="input"
        autocomplete="off"
        class="form_input"
        type="date"
        :value="formatYYYYMMDD(dateSelected)"
        :disabled="disabled"
        :min="(minDate ? formatYYYYMMDD(minDate) : null)"
        :max="(maxDate ? formatYYYYMMDD(minDate) : null)"
        :name="input_name"
        :id="input_id"
        :placeholder="input_placeholder"
        :aria-label="input_label"
        :class="input_class"
      >
    </template>
  </div>
</template>

<script>
import { checkMobile } from './utils.js';
import DatepickerTable from './DatepickerTable.vue';

export default {
  components: {
    DatepickerTable,
  },
  data(){
    const focusedDate = this.dateParser(this.value) || this.dateCreator();

    return {
      isActive: false,
      dayNames: ['Su','M','Tu','W','Th','F','S'],
      monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
      dateSelected: this.dateParser(this.value),
      focusedDateData: {
        date: new Date(focusedDate),
        month: focusedDate.getMonth(),
        year: focusedDate.getFullYear()
      },
      parsedMinDate: (this.minDate ? this.dateParser(this.minDate) : null),
      parsedMaxDate: (this.maxDate ? this.dateParser(this.maxDate) : null),
      prevMonthDisabled: false,
      nextMonthDisabled: false,
      firstDayOfWeek: 0
    };
  },
  props: {
    events: Object,
    value: String,
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
    editable: Boolean,
    disabled: Boolean
  },
  methods: {
    toggleCalendar(){
      this.isActive = !this.isActive;
    },
    openCalendar(){
      this.isActive = true;
    },
    closeCalendar(){
      this.isActive = false;
    },
    /*
      formatValue() - Format the value to a date string, if possible.
    */
    formatValue(value) {
      if (value && !isNaN(value)) {
        return this.dateFormatter(value)
      } else {
        return null
      }
    },
    /*
      dateParser() - Parse a date string into a Date value.
    */
    dateParser(date){
      return date ? new Date(Date.parse(date)) : new Date();
    },
    /*
      dateCreator() - Return a new Date().
    */
    dateCreator(){
      return new Date();
    },
    /*
      dateFormatter() - Take a Date value and return a date string.
    */
    dateFormatter(date){
      const yyyyMMdd = date.getFullYear() +
          '/' + (date.getMonth() + 1) +
          '/' + date.getDate()
      const d = new Date(yyyyMMdd);
      return d.toLocaleDateString();
    },
    
    /*
      setDateSelected() - Set the dateSelected value to a parsed date.
    */
    setDateSelected(date){
      this.dateSelected = this.dateParser(date);
    },
    /*
      checkWhitelist() - Return whether the event.target is the input field or a child of the calendar.
    */
    checkWhitelist(target){
      return (target === this.$refs.input || this.$refs.input.contains(target) || target === this.$refs.calendar_container || this.$refs.calendar_container.contains(target));
    },
    /*
      onBlur() - On input blur, check if the event.relatedTarget is either the input field or a child of the calendar. If not we can close the calendar, else keep the input field focused.
    */
    onBlur(event){
      if( !this.checkWhitelist(event.relatedTarget) ) {
        this.closeCalendar();
      }else{
        this.$refs.input.focus();
      }
    },
    /*
      onInput() - Update the dateSelected value and close the calendar when the 'input' event happens. The 'input' event is fired by the sub-components when a date is clicked.
    */
    onInput(date){
      this.setDateSelected(date);
      this.closeCalendar();
    },
    /*
      clickedOutside() - This is called by the click event listener added to the document when the component is created. If the user clicks on something that is not the input field or the calendar we can close the calendar.
    */
    clickedOutside(event){
      if( !this.checkWhitelist(event.target) ) {
        this.closeCalendar();
      }
    },
    /*
      isPrevMonthAvailable() - Check if the month previous to the currently focused month is greater than the minDate (if it exists).
    */
    isPrevMonthAvailable(){
      if(this.parsedMinDate){
        let testDate = new Date(this.focusedDateData.date);
        testDate.setMonth(testDate.getMonth() - 1);
        
        return ( testDate > this.parsedMinDate );
      }else{
        return true;
      }
    },
    /*
      isNextMonthAvailable() - Check if the month previous to the currently focused month is less than the maxDate (if it exists).
    */
    isNextMonthAvailable(){
      if(this.parsedMaxDate){
        let testDate = new Date(this.focusedDateData.date);
        testDate.setMonth(testDate.getMonth() + 1);
        
        return ( testDate < this.parsedMaxDate );
      }else{
        return true;
      }
    },
    /*
      isUpdatedDayAvailable() - Check if the focused date can add or subtract days and not go over/under the max/min date (if they are set).
    */
    isUpdatedDayAvailable(value){
      if(value < 0){
        if(this.parsedMinDate){
          let testDate = new Date(this.focusedDateData.date);
          testDate.setDate(testDate.getDate() + value);
          
          return ( testDate > this.parsedMinDate );
        }else{
          return true;
        }
      }else{
        if(this.parsedMaxDate){
          let testDate = new Date(this.focusedDateData.date);
          testDate.setDate(testDate.getDate() + value);
          
          return ( testDate < this.parsedMinDate );
        }else{
          return true;
        }
      }
    },
    
    /*
      updateFocusedDateByDays() - Update the focused date by a number of days, if that date is selectable. Update the focusedDateData object and the prev/nextMonthDisabled booleans.
    */
    updateFocusedDateByDays(value){
      if (this.disabled) return

      if(this.isUpdatedDayAvailable(value)){
        this.focusedDateData.date.setDate(this.focusedDateData.date.getDate() + value);
      }

      this.focusedDateData.month = this.focusedDateData.date.getMonth();
      this.focusedDateData.year = this.focusedDateData.date.getFullYear();

      this.prevMonthDisabled = !this.isPrevMonthAvailable();
      this.nextMonthDisabled = !this.isNextMonthAvailable();
    },

    /*
      prevDay() - Subtract one day from the focused date, if possible.
    */
    prevDay() {
      if(this.isActive){
        this.updateFocusedDateByDays(-1);
        this.setDateSelected(this.focusedDateData.date);
      }
    },

    /*
      prevWeek() - Subtract 7 days from the focused date, if possible.
    */
    prevWeek(){
      if(this.isActive){
        this.updateFocusedDateByDays(-7);
        this.setDateSelected(this.focusedDateData.date);
      }
    },

    /*
      nextDay() - Add 1 day to the focused date, if possible.
    */
    nextDay() {
      if(this.isActive){
        this.updateFocusedDateByDays(1);
        this.setDateSelected(this.focusedDateData.date);
      }
    },

    /*
      nextWeek() - Add 7 days to the focused date, if possible.
    */
    nextWeek() {
      if(this.isActive){
        this.updateFocusedDateByDays(7);
        this.setDateSelected(this.focusedDateData.date);
      }
    },

    /*
      prevMonth() - If possible, change the visible calendar month to the prev month. Note: this doesn't set the dateSelected value.
    */
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
      nextMonth() - If possible, change the visible calendar month to the next month. Note: this doesn't set the dateSelected value.
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
  },
  computed: {
    /*
      monthDisplay() - Return a computed month/year string. Ex: June 2019
    */
    monthDisplay() {
      return this.monthNames[this.focusedDateData.month] + ' ' + this.focusedDateData.year;
    },
    /*
      isMobile() - Check if the browser string represents a mobile browser.
    */
    isMobile() {
      return checkMobile.any()
    }
  },
  watch: {
    dateSelected(value) {
      const currentDate = !value ? this.dateCreator() : value;
      this.focusedDateData = {
        date: new Date(currentDate),
        month: currentDate.getMonth(),
        year: currentDate.getFullYear()
      };
    },

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
  },
  /*
    When the component is created, add a 'click' event listener to the document so we can close the calendar if the user clicks outside the input field or the calendar.
  */
  created(){
    if (!(this.isMobile || this.inline) && typeof window !== 'undefined') {
      document.addEventListener('click', this.clickedOutside);
    }
  },
  /*
    Clean up the 'click' event listener on the document when we destroy the component.
  */
  beforeDestroy() {
    if (!(this.isMobile || this.inline) && typeof window !== 'undefined') {
      document.removeEventListener('click', this.clickedOutside);
    }
  }
}
</script>
