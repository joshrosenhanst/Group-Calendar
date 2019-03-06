import tabs from '../../mixins/tabs.js';

const mixins = [tabs];

window.GroupCalendar = window.GroupCalendar || {};
GroupCalendar.data = {
  tabs: ['upcoming_events','past_events'],
  activeTab: 'upcoming_events'
};
GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("group.events page app loaded");
  }
});