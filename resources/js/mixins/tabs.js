export default {
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