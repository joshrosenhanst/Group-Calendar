@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<form id="login_form" class="form card" method="POST" action="{{ route('authenticate') }}">
  @csrf

  <header class="card_header">
    <h1>Group Calendar Login</h1>
  </header>
  <main class="card_body">
    <section class="card_section">
      @include('partials.form_group', [
        'label' => ['text'=>'Email Address'],
        'input' => [
          'name' => 'email',
          'type' => 'email',
          'id' => 'email',
          'placeholder' => 'Email Address',
          'old' => old('email')
        ],
        'errors' => $errors->get('email')
      ])
      @include('partials.form_group', [
        'label' => ['text'=>'Password'],
        'input' => [
          'name' => 'password',
          'type' => 'password',
          'id' => 'password',
          'placeholder' => 'Password'
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
        <a href="#" class="button button-text">Forgot Your Password?</a>
      </div>
    </section>
  </main>
</form>
@endsection