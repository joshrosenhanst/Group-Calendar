<template>
  <button class="navbar_item navbar_menu_button" role="button" aria-label="menu" aria-expanded="false" title="Show Menu"
    v-bind:class="{ 'navbar_menu_button-active': isActive }"
    v-on:click="toggleMenu"
  >
    <material-icon name="menu"></material-icon>
  </button>
</template>

<script>
export default {
  data: function(){
    return {
      isActive: false
    };
  },
  methods: {
    toggleMenu(){
      this.isActive = !this.isActive;
      this.$emit('navbar-menu-toggle', this.isActive);
    }
  }
}
</script>
