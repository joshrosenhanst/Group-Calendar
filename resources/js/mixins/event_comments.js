import CommentsCard from '../components/comments/CommentsCard.vue';
export default {
  components: {
    CommentsCard
  },
  methods: {
    createComment: function(text){
      let url = this.asset_url+'/ajax/events/'+this.event.id+'/comment/create';
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
      let url = this.asset_url+'/ajax/events/'+this.event.id+'/comment/'+comment_id+'/update';
      axios.put(url,{
        'text': text
      }).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      let url = this.asset_url+'/ajax/events/'+this.event.id+'/comment/'+comment_id+'/delete';
      axios.delete(url).then((response) => {
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};