export default {
  methods: {
    /* COMMENTS */
    createComment: function(text){
      let url = this.asset_url+'/ajax/groups/'+this.group.id+'/comment/create';
      axios.put(url,{
        'text': text,
        'user_id': this.user.id
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    updateComment: function(text,comment_id){
      let url = this.asset_url+'/ajax/groups/'+this.group.id+'/comment/'+comment_id+'/update';
      axios.put(url,{
        'text': text
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      let url = this.asset_url+'/ajax/groups/'+this.group.id+'/comment/'+comment_id+'/delete';
      axios.delete(url).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};