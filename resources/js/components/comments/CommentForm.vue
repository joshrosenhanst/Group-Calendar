<template>
  <form v-on:submit.prevent="submitComment" class="form embedded_form comment_form">
    <div class="form_group" 
      v-bind:class="{ 'form_group-error': errors.length }"
    >
      <label class="form_label"
        v-bind:for="textarea_id"
      >{{ label }}</label>
      <textarea class="form_input form_input-small" 
      v-bind:placeholder="`${label}...`" 
      v-model="formText"
      v-bind:id="textarea_id"
      ></textarea>
      <div class="form_errors" v-if="errors.length">
        <div class="form_error" role="alert" 
          v-for="(error,index) in errors"
          v-bind:key="index"
        >{{ error }}</div>
      </div>
    </div>
    <div class="comment_form_footer button_group button_group-small">
      <button class="button button-link button-inverted" type="submit">
        <material-icon name='comment-check'></material-icon>
        <span>
          <slot></slot>
        </span>
      </button>
      <button class="button button-cancel" v-on:click.prevent="cancelComment" v-if="id">
        <material-icon name='cancel'></material-icon>
        <span>Cancel</span>
      </button>
    </div>
  </form>
</template>

<script>
export default {
  data: function(){
    return {
      errors: [],
      formText: this.text
    };
  },
  props: {
    text: String,
    id: Number,
    textarea_id: String,
    label: String
  },
  methods: {
    submitComment: function() {
      console.log("CommentForm submitComment")
      this.errors = [];
      if(this.formText){
        this.$emit('submit-comment',{text:this.formText,id:this.id});
        this.formText = '';
      }else{
        this.errors.push('The comment text field is required.');
      }
    },
    cancelComment: function() {
      this.$emit('cancel-comment');
      this.formText = this.text;
    }
  }
}
</script>
