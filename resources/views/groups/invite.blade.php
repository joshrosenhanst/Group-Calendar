@extends('layouts.landing')

@section('title', 'Invite To Group')

@section('content')
<article id="maincontent">
  <div class="card">

  <div class="card_header card_header-no_content"></div>
  <div class="card_section card_section-title">
    {{ Breadcrumbs::render('groups.invite', $group) }}

    <h1 class="title">
      <span class="icon">@materialicon('account-plus')</span>
      <span>@lang('pages.groups.invite.title')</span>
    </h1>

    <div class="subtitle">@lang('pages.groups.invite.subtitle')</div>
  </div>

  <form action="{{ route('groups.invites.createInvite', ['group'=>$group]) }}" class="form form-centered card_section card_section-form" method="POST">
    @method('PUT')
    @csrf

    {{-- Group Name --}}
    @component('partials.form_inline_static', [
      'label' => ['text' => 'Group']
    ])
    <span class="preview_thumbnail">
      <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
    </span>
    <strong>{{ $group->name }}</strong>
    @endcomponent

    {{-- Invitee Name --}}
    @include('partials.form_inline_group', [
      'label' => ['text' => 'Invitee Name'],
      'input' => [
        'name' => 'name',
        'type' => 'text',
        'id' => 'name',
        'placeholder' => 'Invitee Name',
        'required' => true,
        'old' => old('name')
      ],
      'errors' => $errors->get('name')
    ])

    {{-- Invitee Email --}}
    @include('partials.form_inline_group', [
      'label' => ['text' => 'Invitee Email'],
      'input' => [
        'name' => 'email',
        'type' => 'text',
        'id' => 'email',
        'placeholder' => 'Invitee Email Address',
        'required' => true,
        'old' => old('email')
      ],
      'errors' => $errors->get('email')
    ])

    <div class="form_footer">
      <button type="submit" class="button button-link">
        <span class="icon">@materialicon('account-check')</span>
        <span>Send Invite</span>
      </button>
    </div>

  </form>

  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection