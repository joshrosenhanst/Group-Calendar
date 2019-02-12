<a class="member_preview" href="{{ route('users.view', ['user'=>$user]) }}">
  <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} Avatar" title="{{ $user->name }}">
</a>