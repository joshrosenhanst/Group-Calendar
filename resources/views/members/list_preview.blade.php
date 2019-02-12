<div class="member_list_preview list_item">
  <a class="preview_thumbnail" href="{{ route('users.view', ['user'=>$user]) }}">
    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} Avatar">
  </a>
  <a href="{{ route('users.view', ['user'=>$user]) }}" class="preview_name">{{ $user->name }}</a>
</div>