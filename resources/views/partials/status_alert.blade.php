@isset($body)
<div class="alert {{ $color ? 'alert-'.$color: '' }}" v-if="statusVisible">
  <div class="alert_buttons">
    <button class="button-icon" aria-label="Hide Alert" v-on:click="statusVisible = false">
      <span class="icon">@materialicon('close')</span>
    </button>
  </div>
  <strong>Note: </strong>{{ $body }}
</div>
@endisset