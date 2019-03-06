const mixins = [];

window.GroupCalendar = window.GroupCalendar || {};
GroupCalendar.app = new Vue({
  el: '#app',
  data: {
    showEndDate: false
  },
  mixins: mixins,
  mounted: function(){
    console.log("events.new page app loaded");
  }
});