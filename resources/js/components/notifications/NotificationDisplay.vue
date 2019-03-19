<template>
  <div class="navbar_dropdown dropdown"
    aria-haspopup="true"
    role="button"
    aria-label="Unread Notifications dropdown"
    :class="{ 'dropdown-active': isActive }"
    :aria-expanded="isActive"
    :title="title"
  >
    <div class="dropdown_toggle" ref="trigger">
      <a href="/notifications" class="navbar_item navbar_item-icon has_badge"
        @click.prevent="openDropdown"
        @focus="openDropdown"
        @blur.prevent="onBlur"
      >
        <span class="badge" v-show="unread_notifications">
          {{ unread_notifications }}
        </span>
        <material-icon name="bell"></material-icon>
      </a>
    </div>

    <div class="dropdown_items" 
      aria-role="menu"
      ref="dropdown_items"
      v-bind:aria-hidden="!isActive"
      @blur.capture="onBlur"
    >
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      isActive: false,
      unread_notifications: (this.count || 0)
    }
  },
  props: {
    user_id: Number,
    count: Number
  },
  methods: {
    markUserNotifcationsAsRead(){
      if(this.user_id){
        axios.put(`/ajax/notifications/${this.user_id}/readAll`)
        .then((response) => {
          this.unread_notifications = 0;
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    openDropdown(){
      this.isActive = true;
      this.markUserNotifcationsAsRead();
    },
    closeDropdown(){
      this.isActive = false;
    },
    /*
      checkWhitelist() - Return whether the event.target is the $refs.trigger field or a child of the $refs.dropdown_items.
    */
    checkWhitelist(target){
      return (target === this.$refs.trigger || this.$refs.trigger.contains(target) || target === this.$refs.dropdown_items || this.$refs.dropdown_items.contains(target));
    },
    /*
      onBlur() - On $refs.trigger blur, check if the event.relatedTarget is either the trigger field or a child of $refs.dropdown_items. If not we can close the dropdown.
    */
    onBlur(event){
      if( !this.checkWhitelist(event.relatedTarget) ) {
        this.closeDropdown();
      }
    },
  },
  computed: {
    title() {
      if(this.unread_notifications){
        return this.unread_notifications+" Unread Notifications";
      }else{
        return "No Unread Notifications";
      }
    }
  }
}
</script>
