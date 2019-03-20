@extends('layouts.pagewrapper')

@section('title', 'Group Members')

@section('content')
<article id="maincontent">
  <div class="card">
      {{-- Page Header --}}
      
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.members', $group) }}
      <h1 class="title">
        <span class="icon">@materialicon('account-multiple')</span>
        <span>@lang('pages.groups.members.title')</span>
      </h1>
      {{-- Page subtitle is based on Auth::user() priveleges --}}
      @can('updateMember', $group)
        <div class="subtitle">@lang('pages.groups.members.subtitle.admin')</div>
      @elsecan('members', $group)
        <div class="subtitle">@lang('pages.groups.members.subtitle')</div>
      @endcan

      @if(session('status'))
        <status-alert class="alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <strong>Note: </strong> {{ session('status') }}
        </status-alert>
      @endif

    </div>

  </div>

  <tab-wrapper
    v-bind:tab-items="tabs"
    v-on:select-tab="selectTab"
  >
    <template slot="members">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Members</span>
    </template>
    <template slot="invited">
      <span class="icon">@materialicon('account-plus')</span>
      <span>Invited</span>  
    </template>
  </tab-wrapper>

  <div class="tab members_tab" v-show="activeTab === 'members'">
    <div class="card card-has_tabs">
      <div class="card_sub_header">
        <h1 class="sub_title">{{ $group->name }} - @{{ member_count }}</h1>
      </div>
      {{-- List of Members --}}
      <member-list
        v-bind:members="members"
        @can('updateMember',$group)
        v-bind:show_controls="true"
        @endcan
        v-on:update-member="updateMember"
        v-on:remove-member="removeMember"
        v-bind:asset_url="asset_url"
        type="members"
      ></member-list>

      <div class="card_section card_list">
        <div class="empty list_empty" v-if="members.length == 0">
          <span class="icon">@materialicon('account-question-outline')</span>
          <h2>No Members</h2>
        </div>
      </div>

    </div>
  </div>

  <div class="tab invited_tab" v-show="activeTab === 'invited'">
    <div class="card card-has_tabs">
      <div class="card_sub_header">
        <h1 class="sub_title">{{ $group->name }} - @{{ invited_count }}</h1>
      </div>
      {{-- List of Invited Users --}}
      <member-list
        v-bind:members="invited"
        v-bind:asset_url="asset_url"
        type="invited"
      ></member-list>

      <div class="card_section card_list">
        <div class="empty list_empty" v-if="invited.length == 0">
          <span class="icon">@materialicon('account-question-outline')</span>
          <h2>No Invited Users</h2>
        </div>
      </div>

    </div>
  </div>

</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Members Sidebar --}}
  @include('layouts.sidebar.members', ['group'=>$group])
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset(mix('/js/pages/groups/members.js')) }}"></script>
@endsection