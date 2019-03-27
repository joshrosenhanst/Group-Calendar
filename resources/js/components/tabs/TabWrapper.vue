<template>
  <div class="tabs">
    <div role="tablist" class="tablist" ref="tablist">
      <a class="tab" role="tab" tabindex="0" ref="tab"
        v-for="(tabItem, index) in tabItems"
        v-bind:key="tabItem"
        v-bind:class="{ 'tab-active':(activeTab === index) }"

        @click="selectTab(index)"
        @keydown.enter.prevent="selectTab(index)"
        @keydown.space.prevent="selectTab(index)"
        @keydown.left.prevent="focusPreviousTab(index)"
        @keydown.right.prevent="focusNextTab(index)"
      >
        <slot v-bind:name="tabItem"></slot>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    tabItems: Array
  },
  data: function(){
    return {
      activeTab: 0
    };
  },
  methods: {
    selectTab(tabIndex){
      if(this.activeTab === tabIndex) return;

      this.activeTab = tabIndex;
      this.$emit('select-tab', this.tabItems[tabIndex]);
    },
    focusPreviousTab(tabIndex){
      if(tabIndex === 0){
        tabIndex = this.tabItems.length - 1;
      }else{
        tabIndex--;
      }
      this.$refs.tab[tabIndex].focus();
    },
    focusNextTab(tabIndex){
      if(tabIndex === this.tabItems.length - 1){ 
        tabIndex = 0;
      }else{
        tabIndex++;
      }
      this.$refs.tab[tabIndex].focus();
    }
  }
}
</script>
