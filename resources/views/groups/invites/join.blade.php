@extends('layouts.landing')

@section('title', 'Join Group')

@section('content')
<article id="maincontent">
  <div class="card">

  <div class="card_header card_header-no_content"></div>
  <div class="card_section card_section-title">
    {{ Breadcrumbs::render('groups.invites.join', $group) }}

    <h1 class="title">
      <span class="icon">@materialicon('account-plus')</span>
      <span>@lang('pages.groups.invites.join.title')</span>
    </h1>

    <div class="subtitle">@lang('pages.groups.invites.join.subtitle')</div>
  </div>

  <form action="{{ route('groups.invites.acceptInvite', ['group'=>$group]) }}" class="form card_section card_section-form" method="POST">
    @method('PUT')
    @csrf

    <div class="form_section">
      {{-- Group Name --}}
      @component('partials.form_inline_static', [
        'label' => ['text' => 'Group']
      ])
      <span class="preview_thumbnail">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </span>
      <strong>{{ $group->name }}</strong>
      @endcomponent
  
      @if($creator)
        {{-- Inviter Name --}}
        @component('partials.form_inline_static', [
          'label' => ['text' => 'Inviter']
        ])
        <span class="preview_thumbnail">
          <img src="{{ asset($creator->avatar) }}" alt="{{ $creator->name }} Avatar">
        </span>
        <strong>{{ $creator->name }}</strong>
        @endcomponent
      @endif
    </div>

    <h2 class="form_confirmation">
      Do you want to join <strong>{{ $group->name }}</strong>?
    </h2>

    <div class="form_footer">

      <button type="submit" class="button button-success">
        <span class="icon">@materialicon('account-check')</span>
        <span>Yes, Join Group</span>
      </button>

      <a href="{{ route('groups.invites.decline', ['group'=>$group]) }}" class="button button-danger">
        <span class="icon">@materialicon('close')</span>
        <span>No, Decline Invitation</span>
      </a>

    </div>

  </form>

  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection