<template>
  <div v-if="statusVisible">

    <div class="alert_buttons" v-if="closeButton">
      <button class="button-icon" aria-label="Hide Alert" 
        v-on:click="statusVisible = false"
      >
        <material-icon name="close"></material-icon>
      </button>
    </div>

    <div class="alert_icon" v-if="icon">
      <material-icon v-bind:name="icon"></material-icon>
    </div>

    <div class="alert_text">
      <slot></slot>
    </div>

  </div>
</template>

<script>
export default {
  data: function(){
    return {
      statusVisible: true
    };
  },
  props: {
    icon: {
      type: String,
      required: false
    },
    closeButton: {
      type: Boolean,
      default: false
    }
  }
}
</script>
