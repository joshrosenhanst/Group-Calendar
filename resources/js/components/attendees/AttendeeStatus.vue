<template>
  <div id="attendee_controls">
    <div class="event_detail" 
      v-bind:class="status"
      v-if="status"
    >
      <material-icon 
        v-bind:name='status_icons[status]' 
        aria-label="My Attendee Status"
        class="icon-full_size"
        ></material-icon>
      <div class="detail_content">
        <span class="status_content">{{ status_text[status] }}</span>
        <small>
          <a href="#change_attendee_status" id="change_attendee_status"
            class="button button-text button-inline" 
            title="Change My Attendee Status"
            v-on:click.prevent="changeStatus"
            v-on:keydown.enter.prevent="changeStatus"
            v-on:keydown.space.prevent="changeStatus"
            v-bind:class="{ 'button-active': showStatusChange }"
          >
            Change My Status
          </a>
        </small>
      </div>
    </div>
    <div class="attend_buttons button_group" aria-label="Change My Status" v-show="showStatusChange">
      <a href="#going" class="button button-success button-inverted" title="Set My Status to Going" aria-label="Set My Status to Going" 
        v-on:click.prevent="update('going')"
        v-on:keydown.enter.prevent="update('going')"
        v-on:keydown.space.prevent="update('going')"
      >
        <material-icon name='account-check'></material-icon>
        <span>Going</span>
      </a>
      <a href="#interested" class="button button-info button-inverted" title="Set My Status to Interested" aria-label="Set My Status to Interested" 
        v-on:click.prevent="update('interested')"
        v-on:keydown.enter.prevent="update('interested')"
        v-on:keydown.space.prevent="update('interested')"
      >
        <material-icon name='star'></material-icon>
        <span>Interested</span>
      </a>
      <a href="#unavailable" class="button button-danger button-inverted" title="Set My Status to Unavailable" aria-label="Set My Status to Unavailable"
        v-on:click.prevent="update('unavailable')"
        v-on:keydown.enter.prevent="update('unavailable')"
        v-on:keydown.space.prevent="update('unavailable')"
      >
        <material-icon name='account-remove'></material-icon>
        <span>Unavailable</span>
      </a>
    </div>
  </div>
</template>

<script>
import { status_icons,status_text } from '../../lang/status.js';
export default {
  data: function(){
    return {
      status_icons: status_icons,
      status_text: status_text,
      showStatusChange: !this.status
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
  }
}
</script>
