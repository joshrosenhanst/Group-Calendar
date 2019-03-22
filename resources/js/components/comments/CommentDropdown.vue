<template>
  <div class="comment_slide_drawer" :class="{ 'drawer-active': isActive }">
    <div class="drawer_items">
      <a href="#" class="drawer_item action_icon action_icon-link" aria-label="Edit Comment" title="Edit Comment" v-on:click.prevent="toggleCommentForm">
        <material-icon name="pencil"></material-icon>
      </a>
      <a href="#" class="drawer_item action_icon action_icon-link" aria-label="Delete Comment" title="Delete Comment" v-on:click.prevent="toggleDeleteForm">
        <material-icon name="delete"></material-icon>
      </a>
    </div>
    <div class="drawer_toggle">
      <a class="action_icon action_icon-link" aria-label="Edit or Delete Comment" title="Edit or Delete Comment"        
        @click.prevent="toggleDropdown"
        @keydown.enter.prevent="toggleDropdown"
        @keydown.space.prevent="toggleDropdown"
        @blur.prevent="onBlur"
      >
        <material-icon :name="icon"></material-icon>
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
  },
  computed: {
    icon(){
      return this.isActive ? 'chevron-left' : 'chevron-down';
    }
  }
}
</script>
