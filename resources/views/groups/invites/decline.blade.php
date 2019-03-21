@extends('layouts.pagewrapper')

@section('title', 'Decline Invitation')

@section('content')
<article id="maincontent">
  <div class="card">

    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.invites.decline', $group) }}

      <h1 class="title">
        <span class="icon">@materialicon('account-remove')</span>
        <span>@lang('pages.groups.invites.decline.title')</span>
      </h1>

    </div>

    <form action="{{ route('groups.invites.declineInvite', ['group'=>$group]) }}" class="form card_section card_section-form" method="POST">
      @method('PUT')
      @csrf

      <div class="form_section form_section-top">
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
        Are you sure you want to decline the invitation from <strong>{{ $group->name }}</strong>?
      </h2>

      <div class="form_footer">

        <button type="submit" class="button button-danger">
          <span class="icon">@materialicon('close')</span>
          <span>Yes, Decline Invitation</span>
        </button>

        <a href="{{ route('home') }}" class="button button-cancel">
          <span class="icon">@materialicon('cancel')</span>
          <span>Cancel</span>
        </a>
        
      </div>

    </form>

  </div>
</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection