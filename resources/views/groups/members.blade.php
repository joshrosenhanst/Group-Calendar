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
  
});
</script>
@endpush

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset('/js/pages/groups/members.js') }}"></script>
@endsection