<template>
  <aside id="sidebars"
    v-bind:class="{ 'sidebars-open': active }"
  >
    <slot></slot>
  </aside>
</template>

<script>
export default {
  props: {
    active: Boolean
  }
}
</script>
