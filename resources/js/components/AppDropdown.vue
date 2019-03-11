<template>
  <div class="dropdown" v-bind:class="{ 'dropdown-active': isActive }"
    aria-haspopup="true"
    v-bind:aria-expanded="isActive"
    role="button"
  >
    <div class="dropdown_toggle" ref="trigger"
      v-on:click.prevent="toggleDropdown"
    >
      <slot name="trigger"></slot>
    </div>
    <div class="dropdown_items" aria-role="menu"
      ref="dropdown_items"
      v-bind:aria-hidden="!isActive"
    >
      <slot name="dropdown_items"></slot>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      isActive: this.inline
    }
  },
  props: {
    inline: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    toggleDropdown(){
      if(!this.inline){
        if(!this.isActive){
          this.$nextTick(() => {
            this.isActive = !this.isActive;
            this.$emit('dropdown-active');
            this.$emit('dropdown-status', this.isActive);
          });
        }else{
          this.isActive = !this.isActive;
          this.$emit('dropdown-status', this.isActive);
        }
      }
    },
    isInWhiteList(target){
      if(target === this.$refs.trigger || this.$refs.trigger.contains(target) || target === this.$refs.dropdown_items || this.$refs.dropdown_items.contains(target)){
        return true;
      }

      return false;
    },
    clickedOutside(event){
      if( !this.isInWhiteList(event.target) ) this.isActive = false;
      this.$emit('dropdown-status', this.isActive);
    }
  },
  created(){
    if (!this.inline && typeof window !== 'undefined') {
      document.addEventListener('click', this.clickedOutside)
    }
  },
  beforeDestroy() {
    if (!this.inline && typeof window !== 'undefined') {
      document.removeEventListener('click', this.clickedOutside)
    }
  }
}
</script>
