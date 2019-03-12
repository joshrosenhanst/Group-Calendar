
<div class="{{ $errors?'form_inline_group form_group-error':'form_inline_group'}}">
  <div class="field">
    {{-- FORM LABEL --}}
    <div class="field_label">
      @isset($label)
      <label
        @isset($input['id'])
        for="{{ $input['id'] }}"
        @endisset
        class="{{ $label['class'] ?? 'form_label' }}">
          {{ $label['text'] }}
          @isset($input['required'])<span class="required">*</span>@endisset
      </label>
      @endisset
    </div>
  
    <div class="field_body">
      <image-selection
        :available_images="{{ $images }}"
        @isset($input['id'])
        input_id="{{ $input['id'] }}"
        @endisset
        @isset($input['name'])
        input_name="{{ $input['name'] }}"
        @endisset
        directory="{{ $input['directory'] }}"
        default_image="{{ $input['default_image'] }}"
        input_value="{{ $input['old'] ?? $input['value'] }}"
      >
        @isset($label['button'])
        <span slot="button_text">{{ $label['button'] }}</span>
        @endisset
      </image-selection>

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