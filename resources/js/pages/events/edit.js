const mixins = [GroupCalendar.defaultMixin];

GroupCalendar.app = new Vue({
  el: '#app',
  data: {
    showEndDate: false
  },
  mixins: mixins,
  mounted: function(){
    console.log("events.edit page app loaded");
  }
});