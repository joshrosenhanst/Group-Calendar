<template>
  <div class="list_item comment_display">
    <div class="card_buttons-top_right">
      <button class="button-icon" aria-label="Edit Comment" title="Edit Comment" 
        v-bind:class="{ 'button-active': isOpen }"
        v-if="showForm"
        v-on:click="toggleCommentForm"
      >
        <material-icon name='pencil'></material-icon>
      </button>
      <button class="button-icon" aria-label="Delete Comment" title="Delete Comment" 
        v-if="showForm"
        v-on:click="toggleDeleteForm"
      >
        <material-icon name='cancel'></material-icon>
      </button>
    </div>
    <h3>{{ comment.user.name }}</h3>
    <div>{{ comment.text }}</div>
    <div class="comment_form comment_form-small" v-if="showForm">
        <comment-form
          v-show="isOpen"
          v-bind:text="comment.text"
          v-bind:id="comment.id"
          v-bind:textarea_id="`comment_textarea_${comment.id}`"
          v-on:submit-comment="submitComment"
          v-on:cancel-comment="cancelComment"
        >
          Update Comment
        </comment-form>
        <comment-delete-form
          v-show="isDeleteOpen"
          v-on:submit-delete="submitDelete"
          v-on:cancel-delete="cancelDelete"
        ></comment-delete-form>
    </div>
  </div>
</template>

<script>
import CommentForm from './CommentForm.vue';
import CommentDeleteForm from './CommentDeleteForm.vue';
export default {
  props: {
    showForm: Boolean,
    isOpen: Boolean,
    isDeleteOpen: Boolean,
    comment: Object
  },
  components: {
    CommentForm, CommentDeleteForm
  },
  methods: {
    toggleCommentForm: function() {
      this.$emit('toggle-comment-form', this.comment.id)
    },
    toggleDeleteForm: function() {
      this.$emit('toggle-delete-form', this.comment.id)
    },
    cancelComment: function() {
      this.$emit('cancel-comment');
    },
    submitComment: function(event) {
      this.$emit('submit-comment',event)
    },
    cancelDelete: function() {
      this.$emit('cancel-delete');
    },
    submitDelete: function() {
      this.$emit('submit-delete', this.comment.id);
    }
  }
}
</script>
