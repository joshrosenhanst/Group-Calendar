<a href="{{ route('groups.view', [$group]) }}" class="group-summary">
  <aside>
    <img src="{{ $group->avatar }}" alt="{{ $group->name }} Avatar">
  </aside>
  <h2>{{ $group->name }}</h2>
</article>