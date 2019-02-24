@extends('layouts.landing')

@section('title', 'Group Members')

@section('content')
<article id="maincontent">
  <div class="card">
      {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.members', $group) }}
      <h1 class="title">
        <span class="icon">@materialicon('account-multiple')</span>
        <span>@lang('pages.groups.members.title')</span>
      </h1>
      {{-- Note: replace with conditional guard check to show pages.groups.members.subtitle.admin text--}}
      <div class="subtitle">@lang('pages.groups.members.subtitle')</div>
      <div class="center_title">
        {{ $group->name }} - {{ trans_choice('messages.member_count',$group->users_count) }}
      </div>
    </div>

    {{-- List of Members --}}
    <member-list
      v-bind:members="members"
      v-on:update-member="updateMember"
      v-on:remove-member="removeMember"
    ></member-list>
    {{--<div class="card_section card_list">
    @foreach($group->users as $user)
      <div class="list_item list_item-large_thumbnails">

        <a class="preview_thumbnail" href="{{ route('users.view', ['user'=>$user]) }}">
          <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} Avatar">
        </a>

        <div class="item_details">
          <a href="{{ route('users.view', ['user'=>$user]) }}" class="preview_name">{{ $user->name }}</a>
          <div class="subtext">
            <strong>Member</strong> · <span>Joined {{ $user->join_date }}</span>
          </div>
          <div class="item_form">
            <member-form
              radio_id="member_radio_{{ $user->id }}"
            ></member-form>
          </div>
        </div>

        <div class="item_controls button_group-controls">
          <button class="button button-info button-inverted button-small">
            <span class="icon">@materialicon('pencil')</span>
          </button>
          <button class="button button-danger button-inverted button-small">
            <span class="icon">@materialicon('delete')</span>
          </button>
        </div>
      </div>
    @endforeach
    </div>--}}

  </div>

</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- Group Members Sidebar --}}
  @include('layouts.sidebar.members', ['group'=>$group])
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    group: @json($group),
    members: @json($group->users)
  },
  methods: {
    updateMember: function(id,role){
      axios.put(`/ajax/groups/${this.group.id}/member/${id}/status`,{
        'role': role
      }).then((response) => {
        console.log(response);
        this.members = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    removeMember: function(id){
      axios.delete(`/ajax/groups/${this.group.id}/member/${id}/delete`).then((response) => {
        console.log(response);
        this.members = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
});
</script>
@endpush