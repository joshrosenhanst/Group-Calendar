<template>
  <div class="timepicker"
    :class="{ 'timepicker-inline': inline, 'timepicker-active': isActive }"
  >
    <app-dropdown
      v-if="!isMobile || inline"
      ref="dropdown"
      :inline="inline"
      v-on:dropdown-status="isActive = $event"
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
        :name="input_name"
        :id="input_id"
        :placeholder="input_placeholder"
        :aria-label="input_label"
        :class="input_class"
        @change="onChange($event.target.value)"
        @focus="$emit('focus', $event)"
        @blur="$emit('blur', $event)"
      >

      <template slot="dropdown_items" :disabled="disabled">
        <div class="timepicker_fields">

          <div class="form_select">
            <select
              v-model="hoursSelected"
              @change="onHoursChange($event.target.value)"
              :disabled="disabled"
              placholder="Hour"
            >
              <option class="initial_option" disabled>HH</option>
              <option
                v-for="hour in hours"
                :key="hour.label"
                :value="hour.value"
              >
                {{ hour.label }}
              </option>
            </select>
          </div>

          <span class="field_static">:</span>
          
          <div class="form_select">
            <select class="form_select"
              v-model="minutesSelected"
              @change="onMinutesChange($event.target.value)"
              :disabled="disabled"
              placholder="Min"
            >
              <option class="initial_option" disabled>MM</option>
              <option
                v-for="minute in minutes"
                :key="minute.label"
                :value="minute.label"
              >
                {{ minute.label }}
              </option>
            </select>
          </div>
          
          <div class="form_select">
            <select
              v-model="ampm"
              @change="onAMPMChange($event.target.value)"
              :disabled="disabled"
            >
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
        </div>
      </template>
    </app-dropdown>

    <input
      v-else
      ref="input"
      slot="trigger"
      autocomplete="off"
      class="form_input"
      type="time"
      :value="formatHHMMSS(dateSelected)"
      :disabled="disabled"
      :name="input_name"
      :id="input_id"
      :placeholder="input_placeholder"
      :aria-label="input_label"
      :class="input_class"
      @focus="$emit('focus', $event)"
      @blur="$emit('blur', $event)"
    >

  </div>
</template>

<script>
import { isMobile } from '../datepicker/utils.js';
export default {
  data: function(){
    return {
      isActive: false,
      dateSelected: new Date(),
      hoursSelected: null,
      minutesSelected: null,
      ampm: null
    };
  },
  props: {
    value: String,
    inline: Boolean,
    editable: Boolean,
    disabled: Boolean,
    incrementMinutes: {
      type: Number,
      default: 1
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
  },
  computed: {
    hours(){
      const hours = [];
      for(let i=1;i<13;i++){
        hours.push({
          label: this.formatNumber(i),
          value: i
        });
      }
      return hours;
    },
    minutes(){
      const minutes = [];
      for(let i=0; i<60; i+=this.incrementMinutes){
        minutes.push({
          label: this.formatNumber(i)
        });
      }
      return minutes;
    },
    isMobile(){
      return isMobile.any();
    }
  },
  methods: {
    formatNumber(num){
      return ( num < 10 ? '0' : '' ) + num;
    },
    onHoursChange(value){
      this.updateDateSelected(value,this.minutesSelected,this.ampm);
    },
    onMinutesChange(value){
      this.updateDateSelected(this.hoursSelected,value,this.ampm);
    },
    onAMPMChange(value){
      this.updateDateSelected(this.hoursSelected,this.minutesSelected,value);
    },
    updateDateSelected(hour,minute,ampm){
      this.ampm = ampm;
      hour = parseInt(hour, 10);
      this.hoursSelected = hour;
      if(this.ampm === "PM"){
        if(hour !== 12){
          hour += 12;
        }
      }else{
        if(hour === 12){
          hour = 0;
        }
      }
      this.minutesSelected = minute;
      this.dateSelected.setHours(hour, minute);
    },
    timeParser(hour, minute, ampm) {
      let date = new Date();
      date.setHours(hour,minute);
      return date;
    },
    onChange(value){
      this.updateInternalDate(value);
    },
    /*
      getTimeFromString(value) - Return {hour,minute,ampm} from a time string. Time string should be formatted as HH:MM PM (12:30 PM).
    */
    getTimeFromString(text){
      let hour = text.substr(0,2);
      let minute = text.substr(3,2);
      let ampm = parseInt(hour,10) < 12 ? "AM" : "PM";

      return {hour,minute,ampm};
    },
    getTimeFromDate(date){
      let hour = date.getHours();
      let minute = date.getMinutes();
      let ampm = hour > 12 ? "PM" : "AM";

      return {hour,minute,ampm};
    },
    formatHHMMSS(value) {
      const date = new Date(value)
      if (value && !isNaN(date)) {
        const hours = date.getHours()
        const minutes = date.getMinutes()
        return this.formatNumber(hours) + ':' +
          this.formatNumber(minutes) + ':00'
      }
      return ''
    },
    formatValue(value){
      if (value && !isNaN(value)) {
        return this.timeFormatter(value, this)
      } else {
        return null
      }
    },
    timeFormatter(date){
      let hours = date.getHours();
      let minutes = date.getMinutes();
      let ampm = "AM";

      if(hours > 11){
        ampm = "PM";
      }
      
      if(hours === 0){
        hours = 12;
      }

      if(hours > 12){
        hours -= 12;
      }

      return this.formatNumber(hours) + ":" + this.formatNumber(minutes) + " " + ampm;
    },
    updateInternalDate(value){
      if(value){
        var {hour,minute,ampm} = this.getTimeFromString(value);
      }else{
        var {hour,minute,ampm} = this.getTimeFromDate(new Date());
      }
      const date = this.timeParser(hour,minute,ampm);
      this.dateSelected = date;
      
      hour = parseInt(hour, 10);
      if(hour === 0 || hour === 24) hour = 12;
      this.hoursSelected = (hour > 12 ? (hour-12) : hour);
      this.minutesSelected = minute;
      this.ampm = ampm;
    }
  },
  watch: {
    value(value){
      this.updateInternalDate(value);
    }
  },
  mounted(){
    this.updateInternalDate(this.value);
  }
}
</script>