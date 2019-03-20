import event_comments from '../../mixins/event_comments.js';
import event_status from '../../mixins/event_status.js';
import AttendeesCard from '../../components/attendees/AttendeesCard.vue';

const mixins = [event_comments,event_status,GroupCalendar.defaultMixin];
GroupCalendar.data.interval_id = null;

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  components: {
    AttendeesCard
  },
  methods: {
    getEvent() {
      let url = this.asset_url + '/ajax/events/' + this.event.id;
      axios.get(url).then((response) => {
        this.event = response.data.event;
        this.comments = response.data.comments;

        if(!this.event.flyer_processing){
          clearInterval(this.interval_id);
        }
      }).catch((error) => {
        console.log(error);
        clearInterval(this.interval_id);
      });
    }
  },
  mounted: function(){
    console.log("events.view page app loaded");
    /* If the flyer is still being processed, check every 3s for updated info */
    if(this.event.flyer_processing){
      this.interval_id = setInterval(this.getEvent, 3000);
    }
  },
});