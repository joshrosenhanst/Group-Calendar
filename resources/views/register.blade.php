@extends('layouts.landing')

@section('title', 'New User Registration')

@section('content')
<article id="maincontent" class="no_sidebar">
  <div class="card">

  <div class="card_header card_header-no_content"></div>
  <div class="card_section card_section-title">

    <h1 class="title">
      <span class="icon">@materialicon('account-plus')</span>
      <span>@lang('pages.register.title')</span>
    </h1>

    <div class="subtitle">@lang('pages.register.subtitle')</div>
  </div>

  <form action="{{ route('submitRegistration', ['group'=>$group]) }}" class="form card_section card_section-form" method="POST">
    @method('PUT')
    @csrf

    {{-- Hidden Token --}}
    <input type="hidden" name="token" value="{{ $token }}">

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

      {{-- Account Name --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Account Name'],
        'input' => [
          'name' => 'name',
          'type' => 'text',
          'id' => 'name',
          'placeholder' => 'Account Name',
          'required' => true,
          'old' => old('name', $user->name)
        ],
        'help' => 'Your name as it is displayed on GroupCalendar.',
        'errors' => $errors->get('name')
      ])

      {{-- Account Email --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Account Email'],
        'input' => [
          'name' => 'email',
          'type' => 'text',
          'id' => 'email',
          'placeholder' => 'Account Email Address',
          'required' => true,
          'old' => old('email', $user->email)
        ],
        'help' => 'The email address that you use to log into GroupCalendar.',
        'errors' => $errors->get('email')
      ])

      {{-- Password --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Password'],
        'input' => [
          'name' => 'password',
          'type' => 'password',
          'id' => 'password',
          'placeholder' => 'Password',
          'required' => true
        ],
        'errors' => $errors->get('password')
      ])

      {{-- Confirm Password --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Confirm Password'],
        'input' => [
          'name' => 'password_confirmation',
          'type' => 'password',
          'id' => 'password_confirmation',
          'placeholder' => 'Confirm Password',
          'required' => true
        ],
        'errors' => $errors->get('password_confirmation')
      ])

    </div>

    <div class="form_footer">

      <button type="submit" class="button button-success">
        <span class="icon">@materialicon('account-check')</span>
        <span>Complete Registration</span>
      </button>

    </div>

  </form>

  </div>
</article>
@endsection