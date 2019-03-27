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
        <status-alert class="alert alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <div class="alert_text">
            <strong>Note: </strong> {{ session('status') }}
          </div>
        </status-alert>
      @endif

    </div>

  </div>

  {{-- Tab navigation --}}
  <nav class="tabs" is="tab-wrapper"    
    v-bind:tab-items="tabs"
    v-on:select-tab="selectTab"
  >
    {{--Noscript: graceful fallback by manually rendering the tabs--}}
    <div class="tabs" slot="noscript">
      <div class="tablist" role="tablist">

        <a href="{{ route('groups.members', ['group'=>$group, 'tab'=>'members']) }}" role="tab" tabindex="0"
          @if(request('tab') === NULL || request('tab') === 'members')
            class="tab tab-active"
          @else
            class="tab"
          @endif
        >
          <span class="icon">@materialicon('account-multiple')</span>
          <span>Members</span>
        </a>

        <a href="{{ route('groups.members', ['group'=>$group, 'tab'=>'invited']) }}" role="tab" tabindex="0"
          @if(request('tab') === 'invited')
            class="tab tab-active"
          @else
            class="tab"
          @endif
        >
          <span class="icon">@materialicon('account-plus')</span>
          <span>Invited</span>   
        </a>
      </div>
    </div>

    {{-- TabWrapper tabs (only visible if JS is running) --}}
    <template slot="members" style="display:none;">
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Members</span>
    </template>
    <template slot="invited" style="display:none;">
      <span class="icon">@materialicon('account-plus')</span>
      <span>Invited</span>  
    </template>
  </nav>

  {{--Tab 1: Members Tab--}}
  <div 
    v-show="(activeTab === 'members')"
    v-bind:class="{ 'active_tab': (activeTab === 'members') }"

    @if(request('tab') === 'members')
    class="tab members_tab active_tab"
    @elseif(request('tab') === 'invited')
    class="tab members_tab"
    @elseif(request('tab') === NULL)
    class="tab members_tab default_tab"
    @endif
  >
    <div class="card card-has_tabs">
      <div class="card_sub_header">
        <h1 class="sub_title">
          <span class="preview_thumbnail">
            <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
          </span>
          <span>
            {{ $group->name }}
            @if(count($group->users))
            {{-- Noscript: the member count is replaced via v-text with a live count if JS is on. --}}
            <small v-text="member_count">{{ trans_choice('messages.member_count', count($group->users)) }}</small>
            @endif
          </span>
        </h1>
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
        empty_text="No Members"
      >
        {{-- Noscript: fall back to rendering a basic list via blocks.members.list --}}
        @include('blocks.members.list', [
          'members' => $group->users,
          'type' => 'members',
          'empty_text' => 'No Members'
        ])
      </member-list>

    </div>
  </div>

  {{--Tab 2: Invited Tab--}}
  <div 
    v-show="(activeTab === 'invited')"
    v-bind:class="{ 'active_tab': (activeTab === 'invited') }"

    @if(request('tab') === 'invited')
    class="tab invited_tab active_tab"
    @else
    class="tab invited_tab"
    @endif
  >
    <div class="card card-has_tabs">
      <div class="card_sub_header">
        <h1 class="sub_title">
          <span class="preview_thumbnail">
            <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
          </span>
          <span>
            {{ $group->name }}
            @if(count($group->group_invites))
            {{-- Noscript: the invited count is replaced via v-text with a live count if JS is on. --}}
            <small v-text="invited_count">{{ trans_choice('messages.invited_count', count($group->group_invites)) }}</small>
            @endif
          </span>
        </h1>
      </div>

      {{-- List of Invited Users --}}
      <member-list
        v-bind:members="invited"
        v-bind:asset_url="asset_url"
        type="invited"
        empty_text="No Pending Invitations"
      >
        {{-- Noscript: fall back to rendering a basic list via blocks.members.list --}}
        @include('blocks.members.list', [
          'members' => $group->group_invites,
          'type' => 'invited',
          'empty_text' => 'No Pending Invitations'
        ])
      </member-list>

    </div>
  </div>

</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
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