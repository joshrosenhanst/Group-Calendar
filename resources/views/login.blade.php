@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<form id="login_form" class="form card card-has_header" method="POST" action="{{ route('authenticate') }}">
  @csrf

  <header class="card_header">
    <h1>GroupCalendar Login</h1>
  </header>
  <section class="card_section">
    @include('partials.form_group', [
      'input' => [
        'name' => 'email',
        'type' => 'email',
        'id' => 'email',
        'placeholder' => 'Email Address',
        'aria-label' => 'Email Address',
        'old' => old('email')
      ],
      'icon' => [
        'align' => 'left',
        'name' => 'email'
      ],
      'errors' => $errors->get('email')
    ])
    @include('partials.form_group', [
      'input' => [
        'name' => 'password',
        'type' => 'password',
        'id' => 'password',
        'placeholder' => 'Password',
        'aria-label' => 'Email Address',
      ],
      'icon' => [
        'align' => 'left',
        'name' => 'lock'
      ],
      'errors' => $errors->get('password')
    ])
    @include('partials.form_group_checkbox', [
      'label' => ['text'=>'Remember Me'],
      'input' => [
        'name' => 'remember',
        'type' => 'checkbox',
        'value' => 1,
        'old' => old('remember')
      ],
      'errors' => $errors->get('remember')
    ])
    <div class="button_group">
      <button type="submit" class="button button-link">Login</button>
      <a href="#">Forgot Your Password?</a>
    </div>
  </section>
</form>
@endsection