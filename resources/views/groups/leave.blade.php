@extends('layouts.landing')

@section('title', 'Leave Group')

@section('content')
<article id="maincontent">
  <div class="card">

    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.leave', $group) }}

      <h1 class="title">
        <span class="icon">@materialicon('account-remove')</span>
        <span>@lang('pages.groups.leave.title')</span>
      </h1>

    </div>

    <form action="{{ route('groups.leaveGroup', ['group'=>$group]) }}" class="form form-small card_section card_section-form" method="POST">
      @method('PUT')
      @csrf

      <div class="form_section event_card">

        <div class="form_sub_header">
          <h1 class="sub_title">Group Details</h1>
        </div>

        {{-- Group Name --}}
        @component('partials.form_inline_static', [
          'label' => ['text' => 'Group']
        ])
        <span class="preview_thumbnail">
          <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
        </span>
        <strong>{{ $group->name }}</strong>
        @endcomponent
    
        {{-- User Join Date --}}
        @component('partials.form_inline_static', [
          'label' => ['text' => 'Join Date']
        ])
        {{ $group->users()->where("user_id",Auth::user()->id)->first()->join_date }}
        @endcomponent
      </div>

      <h2 class="form_confirmation">
        Are you sure you want to leave <strong>{{ $group->name }}</strong>?
      </h2>

      <div class="form_footer">

        <button type="submit" class="button button-danger">
          <span class="icon">@materialicon('close')</span>
          <span>Yes, Leave Group</span>
        </button>

        <a href="{{ route('groups.view', ['group'=>$group]) }}" class="button button-cancel">
          <span class="icon">@materialicon('cancel')</span>
          <span>Cancel</span>
        </a>
        
      </div>

    </form>

  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection