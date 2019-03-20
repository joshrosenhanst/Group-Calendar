import TabWrapper from '../components/tabs/TabWrapper.vue';
export default {
  components: {
    TabWrapper
  },
  data: function(){
    return {
      tabs: [],
      activeTab: null
    };
  },
  methods: {
    selectTab(tab){
      this.activeTab = tab;
    }
  }
};