<template>
  <div class="list_item comment_display">
    <div class="comment_avatar">
      <a v-if="comment.user"
        v-bind:href="$parent.getAssetURL('/users/'+comment.user.id)" class="preview_thumbnail">
        <img v-bind:src="$parent.getAssetURL('/'+comment.user.avatar)" v-bind:alt="`${comment.user.name} Avatar`">
      </a>
      <span v-else class="preview_thumbnail">
        <img :src="$parent.getAssetURL('/img/default_user_avatar.jpg')" alt="Default User Avatar">
      </span>
    </div>
    <div class="comment_body">
      <div class="comment_meta">
        <a v-if="comment.user"
          v-bind:href="$parent.getAssetURL('/users/'+comment.user.id)" 
          class="comment_user_name"
        >{{ comment.user.name }}</a>
        <span class="comment_user_name comment_user_default" v-else>Deleted User</span>
        <span class="comment_date" v-bind:title="comment.created_at"> · {{ comment.created_text }}</span>
        <div class="comment_controls" v-if="showForm">
          <a href="#edit_comment" class="control_link" aria-label="Edit Comment" title="Edit Comment"
            v-on:click.prevent="toggleCommentForm"
            v-on:keydown.enter.prevent="toggleCommentForm"
            v-on:keydown.space.prevent="toggleCommentForm"
          >
            Edit
          </a>
          <a href="#delete_comment" class="control_link" aria-label="Delete Comment" title="Delete Comment" 
            v-on:click.prevent="toggleDeleteForm"
            v-on:keydown.enter.prevent="toggleDeleteForm"
            v-on:keydown.space.prevent="toggleDeleteForm"
          >
            Delete
          </a>
        </div>
      </div>
      <div class="comment_text">
        <div>{{ comment.text }}</div>
        <div class="comment_edited" v-if="comment.edited" v-bind:title="comment.updated_at">Edited {{ comment.updated_text }}</div>
        <div class="comment_forms" v-if="showForm">
          <comment-form
            label="Update Comment"
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
