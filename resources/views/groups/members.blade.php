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
    <div class="card_section card_list">
    @foreach($group->users as $user)
      <div class="list_item list_item-large_thumbnails">

        {{-- Thumbnail --}}
        <a class="preview_thumbnail" href="{{ route('users.view', ['user'=>$user]) }}">
          <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} Avatar">
        </a>

        {{-- Name, Status, forms --}}
        <div class="item_details">
          <a href="{{ route('users.view', ['user'=>$user]) }}" class="preview_name">{{ $user->name }}</a>
          <div class="subtext">
            <strong>Member</strong> · <span>Joined {{ $user->join_date }}</span>
          </div>
          {{-- Interactive vue forms go here --}}
        </div>

        {{-- Button controls --}}
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
    </div>

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

</script>
@endpush