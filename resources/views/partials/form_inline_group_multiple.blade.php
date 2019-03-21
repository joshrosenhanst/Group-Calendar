<div class="{{ $has_errors?'form_inline_group form_group-error':'form_inline_group'}}">
  <div class="field">
    {{-- FORM LABEL --}}
    <div class="field_label">
      @isset($label)
      <label
        @isset( $label['label_for'] )
        for="{{ $label['label_for'] }}"
        @endisset
        class="{{ $label['class'] ?? 'form_label' }}">
          {{ $label['text'] }}
          @isset($label['required'])<span class="required">*</span>@endisset
      </label>
      @endisset
    </div>
  
    <div class="field_body">
      <div class="field_multiple">

        @foreach($inputs as $input)
        <div class="field_input">
          {{-- ICON SUPPORT --}}
          @isset($input['icon'])
            <div class="form_input_icon {{ $input['icon']['align'] == 'right'?'form_input_icon-icon_right':'form_input_icon-icon_left' }}">
              @include('partials.input', [
                'input' => $input, 
                'icon'=>$input['icon'] 
              ])
            </div>
          @else
            @include('partials.input', ['input' => $input])
          @endisset
        </div>
        @endforeach
        
        @isset($slot)
        {{ $slot }}
        @endisset
      </div>

      {{-- FORM HELP --}}
      @isset($help)
        <div class="form_help">{{ $help }}</div>
      @endisset

      {{-- FORM ERRORS --}}
      @foreach ($error_group as $errors)
        @foreach($errors as $error)
        <div class="form_error" role="alert">{{ $error }}</div>
        @endforeach
      @endforeach
    </div>
  </div>
</div>