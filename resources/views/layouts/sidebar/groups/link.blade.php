<a href="{{ route('groups.view', ['group'=>$group]) }}" class="sidebar_link">
  <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar" class="sidebar_image">
  <span>{{ $group->name }}</span>
</a>