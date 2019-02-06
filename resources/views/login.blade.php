@extends('wrapper_landing')

@section('title', 'Login')

@section('content')
<form id="login_form">
  @csrf
  <h1>This is the login page.</h1>
  <label>Email<input type="email" placeholder="Email" name="email"></label>
  <label>Password<input type="password" placeholder="Password" name="password"></label>
</form>
@endsection