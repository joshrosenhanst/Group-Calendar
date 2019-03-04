@if(session('status'))
<div class="alert alert-info">
  <div class="alert_buttons">
    <button class="button-icon" aria-label="Hide Alert" v-on:click="$emit('hide-alert')">
      <span class="icon">@materialicon('close')</span>
    </button>
  </div>
  <strong>Note: </strong>{{ session('status') }}
</div>
@endif