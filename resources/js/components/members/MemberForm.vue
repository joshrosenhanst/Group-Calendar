<template>
  <form v-on:submit.prevent="updateMember" class="form member_form embedded_form">
    <div class="form_group" 
      v-bind:class="{ 'form_group-error': errors.length }"
    >
      <label class="form_label"
        v-bind:for="`member_form_${id}`"
      >Update Member Role</label>

      <label class="form_label form_radio">
        <input type="radio" value="member" name="role" v-model="formRole"
          v-bind:id="`member_form_${id}`"
        > Member
      </label>
      <label class="form_label form_radio">
        <input type="radio" value="admin" name="role" v-model="formRole"> Admin
      </label>

      <div class="form_errors" v-if="errors.length">
        <div class="form_error" role="alert" 
          v-for="(error,index) in errors"
          v-bind:key="index"
        >{{ error }}</div>
      </div>
    </div>
    <div class="member_form_footer button_group button_group-small">
      <button class="button button-link button-inverted" type="submit">
        <material-icon name='account-check'></material-icon>
        <span>Update Member</span>
      </button>
      <button class="button button-cancel" v-on:click.prevent="cancelUpdate" v-if="id">
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
      formRole: this.role
    };
  },
  props: {
    role: String,
    id: Number
  },
  methods: {
    updateMember: function() {
      console.log("MemberForm updateMember")
      this.errors = [];
      if(this.formRole){
        this.$emit('update-member',{role:this.formRole,id:this.id});
      }else{
        this.errors.push('The Member Role field is required.');
      }
    },
    cancelUpdate: function() {
      this.$emit('cancel-update');
      this.formRole = this.role;
    }
  }
}
</script>
