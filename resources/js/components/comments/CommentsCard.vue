<template>
  <div class="card card-has_header comments_card">
    <div class="card_header">
      <h2>
        <material-icon name='comment-multiple'></material-icon>
        <span>{{ title || "Comments"}}</span>
      </h2>
    </div>
    <div class="card_section comments_section card_list card_list-comments" v-if="comments.length">
      <comment-display
        v-for="comment in comments"
        v-bind:key="comment.id"
        v-bind:show-form="(comment.user && user.id === comment.user.id) || user_admin"
        v-bind:is-open="(openCommentForm === comment.id)"
        v-bind:is-delete-open="(openDeleteForm === comment.id)"
        v-bind:comment="comment"

        v-on:toggle-comment-form="toggleCommentForm"
        v-on:toggle-delete-form="toggleDeleteForm"
        v-on:cancel-comment="cancelComment"
        v-on:submit-comment="updateComment"
        v-on:submit-delete="deleteComment"
        v-on:cancel-delete="cancelDelete"
      ></comment-display>
    </div>
    <div class="card_section comments_section" v-else>
      <div class="empty">
        <material-icon name='comment-question-outline'></material-icon>
        <h2>No Comments Found</h2>
      </div>
    </div>
    <div class="card_section card_section-form card_section-new_comment">
      <div class="comment_avatar">
        <a v-bind:href="`/users/${user.id}`" class="preview_thumbnail">
          <img v-bind:src="`/${user.avatar}`" v-bind:alt="`${user.name} Avatar`">
        </a>
      </div>
      <div class="comment_body">
        <comment-form
          textarea_id="new_comment"
          label="Leave a Comment"
          v-on:submit-comment="createComment($event)"
        >Submit Comment</comment-form>
      </div>
    </div>
  </div>
</template>

<script>
import CommentDisplay from './CommentDisplay.vue';
import CommentForm from './CommentForm.vue';
export default {
  data: function(){
    return {
      openCommentForm: null,
      openDeleteForm: null
    }
  },
  components: {
    CommentDisplay, CommentForm
  },
  props: {
    comments: Array,
    user: Object,
    title: String,
    user_admin: Boolean
  },
  methods: {
    createComment: function(event) {
      this.$emit('create-comment',event.text);
    },
    updateComment: function(event) {
      this.$emit('update-comment',event.text,event.id);
      this.openCommentForm = null;
      this.openDeleteForm = null;
    },
    deleteComment: function(id) {
      this.$emit('delete-comment',id);
    },
    toggleCommentForm: function(id) {
      this.openDeleteForm = null;
      if(this.openCommentForm === id){
        this.openCommentForm = null;
      }else{
        this.openCommentForm = id;
      }
    },
    toggleDeleteForm: function(id) {
      this.openCommentForm = null;
      if(this.openDeleteForm === id){
        this.openDeleteForm = null;
      }else{
        this.openDeleteForm = id;
      }
    },
    cancelComment: function() {
      this.openCommentForm = null;
      this.openDeleteForm = null;
    },
    cancelDelete: function() {
      this.openCommentForm = null;
      this.openDeleteForm = null;
    }
  }
}
</script>
