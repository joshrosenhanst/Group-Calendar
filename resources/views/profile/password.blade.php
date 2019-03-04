@extends('layouts.landing')

@section('title', 'Change Password')

@section('content')
<article id="maincontent">
  <div class="card card_has_avatar">
    
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('profile.password') }}
      <h1 class="title">
        <span class="icon">@materialicon('lock')</span>
        <span>@lang('pages.profile.password.title')</span>
      </h1>
    </div>

    <div class="card_section-avatar">
      <img class="card_avatar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
      <div class="card_avatar_name">{{ Auth::user()->name }}</div>
      <div class="card_avatar_subtext">{{ Auth::user()->email }}</div>
    </div>

    <form action="{{ route('profile.updatePassword') }}" class="form form-centered card_section card_section-form" method="POST">
      @method('PUT')
      @csrf

      {{-- Current Password --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Current Password'],
        'input' => [
          'name' => 'current_password',
          'type' => 'password',
          'id' => 'current_password',
          'placeholder' => 'Current Password',
          'required' => true
        ],
        'errors' => $errors->get('current_password')
      ])

      {{-- New Password --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'New Password'],
        'input' => [
          'name' => 'new_password',
          'type' => 'password',
          'id' => 'new_password',
          'placeholder' => 'New Password',
          'required' => true
        ],
        'errors' => $errors->get('new_password')
      ])

      {{-- Confirm New Password --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Confirm New Password'],
        'input' => [
          'name' => 'new_password_confirmation',
          'type' => 'password',
          'id' => 'new_password_confirmation',
          'placeholder' => 'Confirm New Password',
          'required' => true
        ],
        'errors' => $errors->get('new_password_confirmation')
      ])

      <div class="form_footer">
        <button class="button button-link" type="submit">
          <span class="icon">@materialicon('check')</span>
          <span>Update Password</span>
        </button>
      </div>
      
    </form>

  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection