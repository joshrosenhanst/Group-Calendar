import ImageSelection from '../../components/image_selection/ImageSelection.vue';
const mixins = [GroupCalendar.defaultMixin];

GroupCalendar.app = new Vue({
  el: '#app',
  data: GroupCalendar.data,
  mixins: mixins,
  components: {
    ImageSelection
  },
  mounted: function(){
    console.log("groups.edit page app loaded");
  }
});