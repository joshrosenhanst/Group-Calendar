<template>
  <span class="dropdown" v-bind:class="{ 'dropdown-active': isActive }"
    aria-haspopup="true"
    role="button"
  >
    <a class="dropdown_toggle" ref="trigger"
      v-bind:class="trigger_classes"
      v-bind:href="url"
      v-on:click.prevent="toggleDropdown"
    >
      <slot name="trigger"></slot>
    </a>
    <div class="dropdown_items" aria-role="menu"
      ref="dropdown_items"
      v-bind:aria-hidden="!isActive"
    >
      <slot name="dropdown_items"></slot>
    </div>
  </span>
</template>

<script>
export default {
  data: function(){
    return {
      isActive: false
    }
  },
  props: {
    url: {
      type: String,
      default: null
    },
    trigger_classes:{
      type: String,
      default: null
    }
  },
  methods: {
    toggleDropdown(){
      if(!this.isActive){
        this.$nextTick(() => {
          this.isActive = !this.isActive;
        });
      }else{
        this.isActive = !this.isActive;
      }
    },
    isInWhiteList(target){
      if(target === this.$refs.trigger || this.$refs.trigger.contains(target) || target === this.$refs.dropdown_items || this.$refs.dropdown_items.contains(target)){
        console.log("whitelist");
        return true;
      }

      console.log("outside click");
      return false;
    },
    clickedOutside(event){
      if( !this.isInWhiteList(event.target) ) this.isActive = false;
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
