<div class="empty {{ $class ?? null }}">
  @isset($icon)
    <span class="icon">@materialicon($icon)</span>
  @endisset
  <h2>{{ $slot }}</h2>
  @isset($button)
  {{ $button }}
  @endisset
</div>