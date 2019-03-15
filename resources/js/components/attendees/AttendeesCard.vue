<template>
  <div class="card card-has_header" id="attendees">
    <div class="card_header">
      <h2>
        <material-icon name='account-multiple'></material-icon>
        <span>Attendees</span>
      </h2>
    </div>
    <div class="card_section card_list" v-if="attendees.length">
      <div class="list_item attendee_list_preview" 
        v-for="attendee in attendees"
        v-bind:key="attendee.id"
        v-bind:attendee="attendee"
      >
        <a v-bind:href="`/users/${attendee.id}`" class="preview_thumbnail">
          <img v-bind:src="`/${attendee.avatar}`" v-bind:alt="`${attendee.name} Avatar`">
        </a>
        <div class="preview_name">
          <a v-bind:href="`/users/${attendee.id}`">{{ attendee.name }}</a>
          <small class="status" v-bind:class="attendee.pivot.status">{{ status_text[attendee.pivot.status] }}</small>
        </div>
      </div>
    </div>
    <div class="card_section card_list" v-else>
      <div class="empty list_empty">
        <material-icon name='account-question-outline'></material-icon>
        <h2>No Attendees</h2>
      </div>
    </div>
  </div>
</template>

<script>
import { status_text } from '../../lang/status.js';
export default {
  data: function(){
    return {
      status_text: status_text
    }
  },
  props: ['attendees']
}
</script>
