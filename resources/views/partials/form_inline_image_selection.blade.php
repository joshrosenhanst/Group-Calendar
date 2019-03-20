
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
        :available_images="{{ $images->toJson() }}"
        @isset($input['id'])
        input_id="{{ $input['id'] }}"
        @endisset
        @isset($input['name'])
        input_name="{{ $input['name'] }}"
        @endisset
        directory="{{ $input['directory'] }}"
        default_image="{{ $input['default_image'] }}"
        input_value="{{ $input['old'] ?? $input['value'] }}"
        v-bind:asset_url="asset_url"
      >
        {{-- Noscript: fallback to a radio selection --}}
        <div class="form_radio_image_group" slot="noscript">
          <label class="form_radio">
            <img src="{{ $input['default_image'] }}" alt="Default Image">
            <div class="radio_selection">
              <input type="radio"
                @isset($input['name'])
                name="{{ $input['name'] }}"
                @endisset
                @if(($input['old'] ?? $input['value']) === null) checked @endif
                value=""
              > Default Image
            </div>
          </label>
  
          @foreach($images as $image)
          <label class="form_radio">
            <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}">
            <div class="radio_selection">
              <input type="radio"
                @isset($input['name'])
                name="{{ $input['name'] }}"
                @endisset
                value="{{ $image['filename'] }}"
                @if(($input['old'] ?? $input['value']) === $image['filename']) checked @endif
              > {{ $image['filename'] }}
            </div>
          </label>
          @endforeach
        </div>

        {{-- Button Text for modal --}}
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