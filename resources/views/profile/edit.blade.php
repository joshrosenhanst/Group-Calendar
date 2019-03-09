@extends('layouts.landing')

@section('title', 'Edit Profile')

@section('content')
<article id="maincontent">
  <div class="card card_has_avatar">
    
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('profile.edit') }}
      <h1 class="title">
        <span class="icon">@materialicon('account-box')</span>
        <span>@lang('pages.profile.edit.title')</span>
      </h1>
    </div>

    <div class="card_section-avatar">
      <img class="card_avatar_image" src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
      <div class="card_avatar_name">{{ Auth::user()->name }}</div>
      <div class="card_avatar_subtext">{{ Auth::user()->email }}</div>
    </div>

    <form action="{{ route('profile.update') }}" class="form form-centered card_section card_section-form" method="POST">
      @method('PUT')
      @csrf

      {{-- Name --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Account Name'],
        'input' => [
          'name' => 'name',
          'type' => 'text',
          'id' => 'name',
          'placeholder' => 'Name',
          'required' => true,
          'old' => old('name', Auth::user()->name)
        ],
        'help' => 'Your name as it is displayed on GroupCalendar.',
        'errors' => $errors->get('name')
      ])

      {{-- Email --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Account Email'],
        'input' => [
          'name' => 'email',
          'type' => 'email',
          'id' => 'email',
          'placeholder' => 'Email Address',
          'required' => true,
          'old' => old('email', Auth::user()->email)
        ],
        'help' => 'The email address that you use to log into GroupCalendar.',
        'errors' => $errors->get('email')
      ])

      {{--Avatar--}}

      <div class="form_footer">
        <button class="button button-link" type="submit">
          <span class="icon">@materialicon('check')</span>
          <span>Update Profile</span>
        </button>
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