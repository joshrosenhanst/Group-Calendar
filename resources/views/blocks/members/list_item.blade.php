<div class="member_list_preview list_item">
  <a class="preview_thumbnail" href="{{ route('users.view', ['user'=>$user]) }}">
    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} Avatar">
  </a>
  <div class="preview_name">
    <a href="{{ route('users.view', ['user'=>$user]) }}">{{ $user->name }}</a>
    <small class="subtext">{{ $user->join_date }}</small>
  </div>
</div>