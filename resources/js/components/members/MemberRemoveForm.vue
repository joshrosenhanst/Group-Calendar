<template>
  <form class="form member_form embedded_form" v-on:submit.prevent="submitRemove">
    <div class="form_group">
      <label class="form_label">Remove {{member}} from the Group?</label>
    </div>
    <div class="member_form_footer button_group button_group-small">
      <button class="button button-danger button-inverted" type="submit">
        <material-icon name='delete'></material-icon>
        <span>Yes, Remove Member</span>
      </button>
      <button class="button button-cancel" v-on:click.prevent="cancelRemove">
        <material-icon name='cancel'></material-icon>
        <span>Cancel</span>
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    'member': String
  },
  methods: {
    submitRemove: function(){
      this.$emit('submit-remove');
    },
    cancelRemove: function(){
      this.$emit('cancel-remove');
    }
  }
}
</script>
