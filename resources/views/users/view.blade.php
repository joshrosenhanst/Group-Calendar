@extends('layouts.landing')

@section('title', 'User Details')

@section('content')
<article id="maincontent">
  <div class="card card_has_avatar">
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('users.view', $user) }}
      <h1 class="title">
        <span class="icon">@materialicon('account-box')</span>
        <span>{{ $user->name }}</span>
      </h1>
      <div class="subtitle">@lang('pages.users.view.subtitle')</div>
    </div>

    <div class="card_section-avatar">
      <img class="card_avatar_image" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
      <div class="card_avatar_name">{{ $user->name }}</div>
    </div>

    
    <div class="card_section-header">
      <h2>
        <span class="icon">@materialicon('account-group')</span>
        <span>Member Of</span>
      </h2>
    </div>

    {{-- List of Groups --}}
    @if($user->groups->count())

      @foreach($user->groups as $group)
        @component('components.group.summary', ['group'=>$group])
          @slot('links')
          {{-- Check if auth::user has view access on group --}}
          <div class="group_links">
            <a href="{{ route('groups.view', ['group'=>$group]) }}" class="button button-link button-inverted">
              <span class="icon">@materialicon('account-group')</span>
              <span>Group Home Page</span>
            </a>
          </div>
          @endslot
        @endcomponent
      @endforeach

    @else

      <div class="card_section">
        @component('components.empty', ['icon'=>'account-question'])
          <div>No Groups</div>
          <div class="sub_text">The user doesn't belong to any groups.</div>
        @endcomponent
      </div>

    @endif

  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection