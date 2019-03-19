<template>
  <div class="modal"
    v-bind:class="{ 'modal-active': active }"
  >
    <div class="modal_background"
      v-on:click="closeModal"
    ></div>
    <div class="modal_card">

      <header class="modal_card_header">
        <div class="modal_card_title">
          <slot name="title"></slot>
        </div>
        <div class="modal_close">
          <button class="button-icon" aria-label="Hide Modal"
            v-on:click.prevent="closeModal"
          >
            <material-icon name="close"></material-icon>
          </button>
        </div>
      </header>

      <slot name="body"></slot>

      <footer class="modal_card_footer"
        v-if="$slots.footer"
      >
        <slot name="footer"></slot>
      </footer>

    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      selectedItem:  null
    };
  },
  props: {
    active: Boolean
  },
  methods: {
    closeModal(){
      this.$emit('close-modal');
    },
    keyPress(event){
      if (this.active && event.key === "Escape") this.closeModal();
    }
  },
  created(){
    if (typeof window !== 'undefined') {
      document.addEventListener('keyup', this.keyPress)
    }
  },
  beforeDestroy(){
    if (typeof window !== 'undefined') {
      document.removeEventListener('keyup', this.keyPress)
    }
  }
}
</script>
