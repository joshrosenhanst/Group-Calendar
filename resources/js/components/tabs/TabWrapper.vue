<template>
  <nav class="tabs">
    <ul>
      <li
        v-for="(tabItem, index) in tabItems"
        v-bind:key="tabItem"
        v-bind:class="{ 'tab_active':(activeTab === index) }"
      >
        <a v-on:click="selectTab(index)"
        >
          <slot v-bind:name="tabItem"></slot>
        </a>
      </li>
    </ul>
  </nav>
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
    }
  }
}
</script>
