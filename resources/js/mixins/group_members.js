export default {
  methods: {
    updateMember: function(role,id){
      axios.put(`/ajax/groups/${this.group.id}/member/update`,{
        'role': role,
        'user_id': id
      }).then((response) => {
        this.members = response.data.members;
        this.invited = response.data.invited;
      }).catch((error) => {
        console.log(error);
      });
    },
    removeMember: function(id){
      axios.delete(`/ajax/groups/${this.group.id}/member/remove`,{
        data:{
          'user_id': id
        }
      }).then((response) => {
        this.members = response.data.members;
        this.invited = response.data.invited;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
};