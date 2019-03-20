import MemberList from '../components/members/MemberList.vue';
export default {
  components: {
    MemberList
  },
  methods: {
    updateMember: function(role,id){
      let url = this.asset_url+'/ajax/groups/'+this.group.id+'/member/update';
      axios.put(url,{
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
      let url = this.asset_url+'/ajax/groups/'+this.group.id+'/member/remove';
      axios.delete(url,{
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