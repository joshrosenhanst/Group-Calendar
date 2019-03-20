import event_form from '../../mixins/event_form.js';
import ImageSelection from '../../components/image_selection/ImageSelection.vue';
const mixins = [event_form, GroupCalendar.defaultMixin];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  components: {
    ImageSelection
  },
  mounted: function(){
    console.log("events.edit page app loaded");
  }
});