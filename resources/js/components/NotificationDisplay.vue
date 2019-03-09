<template>
  <app-dropdown class="navbar_dropdown"
    aria-label="Unread Notifications dropdown" v-bind:title="title"
    v-on:dropdown-active="markUserNotifcationsAsRead"
  >

    <template slot="trigger">
      <a href="/notifications" class="navbar_item navbar_item-icon has_badge">
        <span class="badge" v-show="unread_notifications">
          {{ unread_notifications }}
        </span>
        <material-icon name="bell"></material-icon>
      </a>
    </template>

    <slot slot="dropdown_items"></slot>

  </app-dropdown>
</template>

<script>
export default {
  data: function(){
    return {
      unread_notifications: (this.count || 0)
    };
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
