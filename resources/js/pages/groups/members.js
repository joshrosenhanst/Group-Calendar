import members from '../../mixins/group_members.js';

const mixins = [members];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("group.members page app loaded");
  }
});