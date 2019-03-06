export default {
  methods: {
    createComment: function(text){
      axios.put(`/ajax/events/${this.event.id}/comment/create`,{
        'text': text,
        'user_id': this.user.id
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    updateComment: function(text,comment_id){
      axios.put(`/ajax/events/${this.event.id}/comment/${comment_id}/update`,{
        'text': text
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      axios.delete(`/ajax/events/${this.event.id}/comment/${comment_id}/delete`).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};