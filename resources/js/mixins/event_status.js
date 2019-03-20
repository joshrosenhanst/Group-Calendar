import AttendeeStatus from '../components/attendees/AttendeeStatus.vue';
export default {
  components: {
    AttendeeStatus
  },
  methods: {
    updateStatus: function(status){
      let url = this.asset_url+'/ajax/events/'+this.event.id+'/attend';
      axios.put(url,{
        'status': status,
        'user_id': this.user.id
      }).then((response) => {
        this.event = response.data.event;
        this.comments = response.data.comments;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};