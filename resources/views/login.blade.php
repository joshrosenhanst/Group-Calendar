@extends('wrapper_landing')

@section('title', 'Login')

@section('content')
<form id="login_form">
  @csrf
  <header>
    <h1>Group Calendar Login</h1>
  </header>
  <main>
      <label>Email Address<input type="email" placeholder="Email Address" name="email"></label>
      <label>Password<input type="password" placeholder="Password" name="password"></label>
      <div class="split_layout">
        <label class="checkbox">
          <input type="checkbox" name="remember"> Remember Me
        </label>
        <a href="#">Forgot Your Password?</a>
      </div>
  </main>
  <footer>
    <button type="submit" class="is-link">Login</button>
    <a href="#" class="button is-text">Try a Demo</a>
  </footer>
</form>
@endsection