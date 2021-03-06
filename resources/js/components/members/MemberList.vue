<template>
<div class="card_section card_list"
  :class="{ 'card_list-mini': (!show_controls && members.length) }"
>
  <template v-if="members.length">
    <div class="list_item list_item-large_thumbnails"
      v-for="member in members"
      v-bind:key="member.id"
    >
      <a v-bind:href="getAssetURL('/users/'+member.id)" class="preview_thumbnail">
        <img 
          v-bind:src="getAssetURL('/'+member.avatar)" 
          v-bind:alt="`${member.name} Avatar`"
        >
      </a>

      <div class="item_controls button_group-controls"  v-if="show_controls">
        <button class="button button-text_info" aria-label="Update Member Role" title="Update Member Role"
          v-bind:class="{ 'button-active': (openMemberForm === member.id) }"
          v-on:click="toggleMemberForm(member.id)"
        >
          <material-icon name='pencil'></material-icon>
        </button>
        <button class="button button-text_danger" aria-label="Remove Member" title="Remove Member"
          v-bind:class="{ 'button-active': (openRemoveForm === member.id) }"
          v-on:click="toggleRemoveForm(member.id)"
        >
          <material-icon name='delete'></material-icon>
        </button>
      </div>

      <div class="item_details">
        <a v-bind:href="getAssetURL('/users/'+member.id)" class="preview_name">{{ member.name }}</a>

        <div class="subtext" v-if="(type === 'members')">
          <strong class="capitalize">{{ member.pivot.role }}</strong> · <span >Joined {{ member.join_date }}</span>
        </div>
        <div class="subtext" v-else>
          <span>Invited {{ member.join_date }}</span>
        </div>

        <div class="item_form" v-if="show_controls">
          <member-form
            v-bind:role="member.pivot.role"
            v-bind:id="member.id"
            v-show="(openMemberForm === member.id)"

            v-on:update-member="updateMember"
            v-on:cancel-update="cancelUpdate"
          ></member-form>
          <member-remove-form
            v-bind:role="member.pivot.role"
            v-bind:member="member.name"
            v-show="(openRemoveForm === member.id)"

            v-on:submit-remove="removeMember(member.id)"
            v-on:cancel-remove="cancelUpdate"
          ></member-remove-form>
        </div>
      </div>

    </div>
  </template>
  <template v-else>
    <div class="empty list_empty">
      <material-icon name="account-question-outline"></material-icon>
      <h2>{{ empty_text }}</h2>
    </div>
  </template>
</div>
</template>

<script>
import MemberForm from './MemberForm.vue';
import MemberRemoveForm from './MemberRemoveForm.vue';
import asset_url from '../../mixins/asset_url.js';
export default {
  mixins: [asset_url],
  components: {
    MemberForm, MemberRemoveForm
  },
  data: function(){
    return {
      openMemberForm: null,
      openRemoveForm: null
    };
  },
  props: {
    members: Array,
    show_controls: Boolean,
    type: String,
    empty_text: String
  },
  methods: {
    updateMember: function(event){
      this.$emit('update-member',event.role,event.id);
      this.openMemberForm = null;
      this.openRemoveForm = null;
    },
    removeMember: function(id){
      this.$emit('remove-member',id);
    },
    cancelUpdate: function(){
      this.openMemberForm = null;
      this.openRemoveForm = null;
    },
    toggleMemberForm: function(id){
      this.openRemoveForm = null;
      if(this.openMemberForm === id){
        this.openMemberForm = null;
      }else{
        this.openMemberForm = id;
      }
    },
    toggleRemoveForm: function(id){
      this.openMemberForm = null;
      if(this.openRemoveForm === id){
        this.openRemoveForm = null;
      }else{
        this.openRemoveForm = id;
      }
    }
  }
}
</script>
