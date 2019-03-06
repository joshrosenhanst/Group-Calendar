import event_comments from '../../mixins/event_comments.js';
import event_status from '../../mixins/event_status.js';

const mixins = [event_comments,event_status];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("events.view page app loaded");
  }
});