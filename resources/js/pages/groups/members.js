import members from '../../mixins/group_members.js';
import tabs from '../../mixins/tabs.js';

const mixins = [tabs,members,GroupCalendar.defaultMixin];
GroupCalendar.data.tabs = ['members','invited'];
GroupCalendar.data.activeTab = 'members';

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("group.members page app loaded");
  },
  computed: {
    member_count(){
      if(this.members.length == 0) return "No Members";
      if(this.members.length == 1) return "1 Member";

      return this.members.length + " Members";
    },
    invited_count(){
      if(this.invited.length == 0) return "No Invited Users";
      if(this.invited.length == 1) return "1 Invited User";

      return this.invited.length + " Invited Users";
    }
  }
});