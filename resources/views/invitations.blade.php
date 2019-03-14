@extends('layouts.landing')

@section('title', 'My Group Invitations')

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('invitations') }}
      <h1 class="title">
        <span class="icon">@materialicon('email')</span>
        <span>@lang('pages.invitations.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.invitations.subtitle')</div>
    </div>

      {{-- List of Groups --}}
    @if(count($groups))

      @foreach($groups as $group)
      <div class="card_section">
        @component('components.group.summary', ['group'=>$group])

          @if($group->pivot->created_at)
            @slot('subtext')
              <div class="group_subtext">
                Invited {{ $group->pivot->join_date }} 
                @if($group->pivot->inviter)
                by <a href="{{ route('users.view', ['user'=>$group->pivot->inviter]) }}">{{ $group->pivot->inviter->name }}</a>
                @endif
              </div>
            @endslot
          @endif

          @slot('links')
          <div class="group_links">
            <a href="{{ route('groups.invites.join', ['group'=>$group]) }}" class="button button-link button-inverted">
              <span class="icon">@materialicon('account-group')</span>
              <span>Join Group</span>
            </a>
            <a href="{{ route('groups.invites.decline', ['group'=>$group]) }}" class="button button-danger button-inverted">
              <span class="icon">@materialicon('account-remove')</span>
              <span>Decline</span>
            </a>
          </div>
          @endslot

        @endcomponent
      </div>
      @endforeach

    @else
      <div class="card_section">
        @component('components.empty', ['icon'=>'account-question'])
          <div>No Pending Invitations</div>
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