import group_comments from '../../mixins/group_comments.js';

const mixins = [group_comments,GroupCalendar.defaultMixin];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("group.view page app loaded");
  }
});