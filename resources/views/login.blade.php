@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<form id="login_form" method="POST" action="{{ route('authenticate') }}">
  @csrf

  <header>
    <h1>Group Calendar Login</h1>
  </header>
  <main>
      <label>
        Email Address
      <input type="email" placeholder="Email Address" name="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
          <span class="form-error" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </label>
      <label>
        Password
        <input type="password" placeholder="Password" name="password">
        @if ($errors->has('password'))
          <span class="form-error" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </label>
      <label class="checkbox">
        <input type="checkbox" name="remember"> Remember Me
      </label>
  </main>
  <footer>
    <button type="submit" class="is-link">Login</button>
    <a href="#" class="button is-text">Forgot Your Password?</a>
  </footer>
</form>
@endsection