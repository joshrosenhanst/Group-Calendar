@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.view', $group) }}
    </div>

    {{-- Group Details --}}
    @component('components.group.summary', ['group'=>$group])
      @slot('links')
        <div class="group_links button_group button_group-inverted button_group-link button_group-small">
            <a href="{{ route('events.new', ['group'=>$group]) }}" class="button">
              <span class="icon">@materialicon('calendar-plus')</span>
              <span>New Event</span>
            </a>
            <a href="{{ route('events.index', ['group'=>$group]) }}" class="button">
              <span class="icon">@materialicon('calendar-range')</span>
              <span>Group Events</span>
            </a>
            <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button">
              <span class="icon">@materialicon('account-multiple')</span>
              <span>Group Members</span>
            </a>
          </div>
      @endslot
    @endcomponent
  </div>

  {{-- Upcoming Events --}}
  @include('blocks.groups.upcoming_events')

  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      {{-- Group Comments --}}
      <comments-card
        v-bind:comments="comments"
        v-bind:user="user"
        title="Group Comments"

        v-on:create-comment="createComment"
        v-on:update-comment="updateComment"
        v-on:delete-comment="deleteComment"
      ></comments-card>
    </div>
    <aside class="maincontent_aside">

      {{-- Recent Members --}}
      @include('blocks.groups.recent_members')
    </aside>
  </div>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    user: @json(Auth::user()),
    group: @json($group),
    comments: @json($group->comments)
  },
  methods: {
    createComment: function(text){
      console.log("create comment",text,this.user.id);
      axios.put(`/ajax/groups/${this.group.id}/comment/create`,{
        'text': text,
        'user_id': this.user.id
      }).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    updateComment: function(text,comment_id){
      axios.put(`/ajax/groups/${this.group.id}/comment/${comment_id}/update`,{
        'text': text
      }).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      axios.delete(`/ajax/groups/${this.group.id}/comment/${comment_id}/delete`).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
});
</script>
@endpush