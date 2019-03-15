<template>
  <span class="icon">
    <svg 
      viewBox="0 0 24 24" 
      xmlns="http://www.w3.org/2000/svg" 
      v-bind:width="size"
      v-bind:height="size" 
      role="presentation"
    >
      <path v-bind:d="icons[name]"></path>
    </svg>
  </span>
</template>

<script>
import Icons from '../../icons.js';
export default {
  data: function() {
    return {
      icons: Icons
    };
  },
  props: {
    size: {
      type: Number,
      default: 24
    },
    name: {
      type: String,
      required: true
    }
  }
}
</script>
