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
      <ul class="dropdown_notifications">

        <template v-if="notifications.length">
          <notification-item 
            v-for="notification in notifications"
            :key="notification.id"
            :notification="notification"
          ></notification-item>
        </template>
        <div class="empty list_empty" v-else>
          <material-icon name="bell-outline"></material-icon>
          <h2>No Unread Notifications</h2>
        </div>

        <div class="dropdown_footer">
          <a href="/notifications" class="button">View All Notifications</a>
        </div>

      </ul>
    </div>
  </div>
</template>

<script>
import NotificationItem from './NotificationItem.vue';
export default {
  components: {
    NotificationItem
  },
  data(){
    return {
      isActive: false,
      unread_notifications: (this.notifications.length || 0)
    }
  },
  props: {
    user_id: Number,
    notifications: Object
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
