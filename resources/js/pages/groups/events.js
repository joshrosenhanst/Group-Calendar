import tabs from '../../mixins/tabs.js';

const mixins = [tabs];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("group.events page app loaded");
  }
});