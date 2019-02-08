@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<form id="login_form" class="form" method="POST" action="{{ route('authenticate') }}">
  @csrf

  <header class="form_header">
    <h1>Group Calendar Login</h1>
  </header>
  <main>
    <label class="form_label">
      Email Address
    <input class="form_input" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}">
      @if ($errors->has('email'))
        <span class="form-error" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
      @endif
    </label>
    <label class="form_label">
      Password
      <input class="form_input" type="password" placeholder="Password" name="password">
      @if ($errors->has('password'))
        <span class="form-error" role="alert">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
      @endif
    </label>
    <label class="form_label form_checkbox">
      <input type="checkbox" name="remember"> Remember Me
    </label>
  </main>
  <footer>
    <button type="submit" class="button button-link">Login</button>
    <a href="#" class="button button-text">Forgot Your Password?</a>
  </footer>
</form>
@endsection