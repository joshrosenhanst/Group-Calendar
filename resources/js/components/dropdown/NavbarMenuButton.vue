<template>
  <button class="navbar_item navbar_menu_button" role="button" aria-label="menu"  aria-haspopup="true" title="Show Menu"
    v-bind:class="{ 'navbar_menu_button-active': isActive }"
    v-on:click="toggleMenu"
    v-bind:aria-expanded="isActive"
    ref="trigger"
  >
    <material-icon name="menu"></material-icon>
  </button>
</template>

<script>
export default {
  props: {
    whitelist: String
  },
  data: function(){
    return {
      isActive: false
    }
  },
  methods: {
    toggleMenu(){
      this.isActive = !this.isActive;
      this.$emit('navbar-menu-toggle', this.isActive);
    },
    isInWhiteList(target){
      if(this.whitelist_element){
        if(target === this.$refs.trigger || this.$refs.trigger.contains(target) || target === this.whitelist_element || this.whitelist_element.contains(target) ){
          return true;
        }
      }else{
        if(target === this.$refs.trigger || this.$refs.trigger.contains(target)){
          return true;
        }
      }

      return false;
    },
    clickedOutside(event){
      if( !this.isInWhiteList(event.target) ){ 
        this.isActive = false;
        this.$emit('navbar-menu-toggle', this.isActive);
      }
    }
  },
  computed: {
    whitelist_element(){
      return document.querySelector(this.whitelist);
    }
  },
  created(){
    if (typeof window !== 'undefined') {
        document.addEventListener('click', this.clickedOutside)
    }
  },
  beforeDestroy() {
    if (typeof window !== 'undefined') {
      document.removeEventListener('click', this.clickedOutside)
    }
  }
}
</script>
