
<div class="form_inline_group">
    <div class="field">
      {{-- FORM LABEL --}}
      <div class="field_label">
        @isset($label)
        <label class="{{ $label['class'] ?? 'form_label' }}">
          {{ $label['text'] }}
        </label>
        @endisset
      </div>
    
      <div class="field_body field_body-static">
        {{-- ICON SUPPORT --}}
        <div class="form_input-static">
            @isset($icon)
              <span class="icon">@materialicon($icon['name'])</span>
            @endisset
            <strong class="form_input-static">{{ $slot }}</strong>
        </div>

        {{-- FORM HELP --}}
        @isset($help)
          <div class="form_help">{{ $help }}</div>
        @endisset
    
        {{-- FORM ERRORS --}}
        @foreach ($errors as $error)
          <div class="form_error" role="alert">{{ $error }}</div>
        @endforeach
      </div>
    </div>
  </div>