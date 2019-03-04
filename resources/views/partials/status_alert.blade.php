@isset($body)
<div class="alert {{ $color ? 'alert-'.$color: '' }}">
  <div class="alert_buttons">
    <button class="button-icon" aria-label="Hide Alert" v-on:click="$emit('hide-alert')">
      <span class="icon">@materialicon('close')</span>
    </button>
  </div>
  <strong>Note: </strong>{{ $body }}
</div>
@endisset