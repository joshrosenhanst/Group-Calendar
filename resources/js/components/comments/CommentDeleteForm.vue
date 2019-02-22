<template>
  <form class="comment_form form" v-on:submit.prevent="submitDelete">
    <div class="form_group">
      <label class="form_label">Delete Comment?</label>
    </div>
    <div class="comment_form_footer button_group button_group-small">
      <button class="button button-danger" type="submit">
        <material-icon name='delete'></material-icon>
        <span>Delete Comment</span>
      </button>
      <button class="button" v-on:click.prevent="cancelDelete">
        <material-icon name='cancel'></material-icon>
        <span>Cancel</span>
      </button>
    </div>
  </form>
</template>

<script>
export default {
  methods: {
    submitDelete: function(){
      this.$emit('submit-delete');
    },
    cancelDelete: function(){
      this.$emit('cancel-delete');
    }
  }
}
</script>
