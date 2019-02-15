
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
      {{-- ICON SUPPORT --}}
      @isset($icon)
        <div class="form_input_icon {{$icon['align'] == 'right'?'form_input_icon-icon_right':'form_input_icon-icon_left'}}">
          @include('partials.input', ['input' => $input, 'icon'=>$icon])
        </div>
      @else
        @include('partials.input', ['input' => $input])
      @endisset

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