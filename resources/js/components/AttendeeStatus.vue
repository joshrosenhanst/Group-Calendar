<template>
  <div id="attendee_controls">
    <div class="event_detail" v-if="status">
      <material-icon 
        v-bind:name='status_icons[status]' 
        aria-label="My Attendee Status"
        class="icon-full_size"
        ></material-icon>
      <div class="detail_content">
        {{ status_text[status] }}
        <small>
          <button 
            class="button button-text button-inline" 
            v-on:click="changeStatus"
            v-bind:class="{ 'button-active': showStatusChange }"
          >
            Change My Status
          </button>
        </small>
      </div>
    </div>
    <div class="attend_buttons button_group" aria-label="Change My Status" v-show="showStatusChange">
      <button class="button button-link button-inverted" v-on:click="update('going')">
        <material-icon name='account-check'></material-icon>
        <span>Going</span>
      </button>
      <button class="button button-info button-inverted" v-on:click="update('interested')">
        <material-icon name='star'></material-icon>
        <span>Interested</span>
      </button>
      <button class="button button-danger button-inverted" v-on:click="update('unavailable')">
        <material-icon name='account-remove'></material-icon>
        <span>Unavailable</span>
      </button>
    </div>
  </div>
</template>

<script>
const status_icons = {
  'pending': 'account-question',
  'interested': 'star',
  'going': 'account-check',
  'unavailable': 'account-remove'
};
const status_text = {
  'pending': 'Pending',
  'interested': 'Interested',
  'going': 'Going',
  'unavailable': 'Unavailable'
};

export default {
  mounted(){
    console.log('AttendeeStatus mounted.');
  },
  data: function(){
    return {
      status_icons: status_icons,
      status_text: status_text,
      showStatusChange: false
    };
  },
  props: ['status'],
  methods: {
    changeStatus: function(){
      this.showStatusChange = !this.showStatusChange;
    },
    update: function(status) {
      this.$emit('update',status);
      this.showStatusChange = false;
    }
  },
  computed: {
  }
}
</script>
