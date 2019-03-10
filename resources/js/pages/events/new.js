const mixins = [GroupCalendar.defaultMixin];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  mounted: function(){
    console.log("events.new page app loaded");
  }
});