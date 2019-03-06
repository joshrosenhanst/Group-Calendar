export default {
  methods: {
    /* COMMENTS */
    createComment: function(text){
      axios.put(`/ajax/groups/${this.group.id}/comment/create`,{
        'text': text,
        'user_id': this.user.id
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    updateComment: function(text,comment_id){
      axios.put(`/ajax/groups/${this.group.id}/comment/${comment_id}/update`,{
        'text': text
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      axios.delete(`/ajax/groups/${this.group.id}/comment/${comment_id}/delete`).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};