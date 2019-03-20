<template>
  <li>

    <a :href="notification.data.url" v-if="notification.data.url" class="dropdown_item">
      <material-icon :name="icon"></material-icon>
      <div class="notification_details">
        <div class="text" v-html="notification.data.text"></div>
        <div class="subtext">{{ notification.created_text }}</div>
      </div>
    </a>
    <div class="dropdown_item" v-else>
      <material-icon :name="icon"></material-icon>
      <div class="notification_details">
        <div class="text" v-html="notification.data.text"></div>
        <div class="subtext">{{ notification.created_text }}</div>
      </div>
    </div>

  </li>
</template>

<script>
export default {
  props:{
    notification: Object
  },
  computed: {
    icon(){
      if(this.notification.data.icon){
        return this.notification.data.icon;
      }else{
        return 'bell-alert';
      }
    }
  }
}
</script>
