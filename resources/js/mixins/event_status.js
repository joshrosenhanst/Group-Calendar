export default {
  methods: {
    updateStatus: function(status){
      axios.put(`/ajax/events/${this.event.id}/attend/`,{
        'status': status,
        'user_id': this.user.id
      }).then((response) => {
        //this.user_status = response.data.user_status;
        this.event = response.data.event;
        this.comments = response.data.comments;
        /*this.going_attendees_count = response.data.going_attendees_count;
        this.interested_attendees_count = response.data.interested_attendees_count;
        this.attendees = response.data.attendees;*/
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};