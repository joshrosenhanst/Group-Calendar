<template>
  <div class="dropdown" v-bind:class="{ 'dropdown-active': isActive }"
    aria-haspopup="true"
    v-bind:aria-expanded="isActive"
    role="button"
  >
    <div class="dropdown_toggle" ref="trigger">
      <button class="action_icon action_icon-link" aria-label="Edit or Delete Comment" title="Edit or Delete Comment"        
        @click.prevent="toggleDropdown"
        @keydown.enter.prevent="toggleDropdown"
        @keydown.space.prevent="toggleDropdown"
        @blur.prevent="onBlur"
      >
        <material-icon name="chevron-down"></material-icon>
      </button>
    </div>
    <div class="dropdown_items" aria-role="menu"
      ref="dropdown_items"
      v-bind:aria-hidden="!isActive"
    >
      <a href="#" class="dropdown_item" aria-label="Edit Comment" title="Edit Comment" v-on:click.prevent="toggleCommentForm">
        <material-icon name="pencil"></material-icon>
        <span>Edit Comment</span>
      </a>
      <a href="#" class="dropdown_item" aria-label="Delete Comment" title="Delete Comment" v-on:click.prevent="toggleDeleteForm">
        <material-icon name="delete"></material-icon>
        <span>Delete Comment</span>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      isActive: false
    }
  },
  methods: {
    toggleDropdown(){
      this.isActive = !this.isActive;
    },
    /*
      checkWhitelist() - Return whether the event.target is the $refs.trigger field or a child of the $refs.dropdown_items.
    */
    checkWhitelist(target){
      return (target === this.$refs.trigger || this.$refs.trigger.contains(target) || target === this.$refs.dropdown_items || this.$refs.dropdown_items.contains(target));
    },
    closeDropdown(){
      this.isActive = false;
    },
    toggleCommentForm(){
      this.closeDropdown();
      this.$emit('toggle-comment-form');
    },
    toggleDeleteForm(){
      this.closeDropdown();
      this.$emit('toggle-delete-form');
    },
    /*
      onBlur() - On $refs.trigger blur, check if the event.relatedTarget is either the trigger field or a child of $refs.dropdown_items. If not we can close the dropdown.
    */
    onBlur(event){
      if( !this.checkWhitelist(event.relatedTarget) ) {
        this.closeDropdown();
      }
    }
  }
}
</script>
