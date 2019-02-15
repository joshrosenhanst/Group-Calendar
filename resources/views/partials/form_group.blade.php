
<div class="{{ $errors?'form_group form_group-error':'form_group'}}">
  {{-- FORM LABEL --}}
  @isset($label)
  <label
    @isset($input['id'])
    for="{{ $input['id'] }}"
    @endisset
    class="{{ $label['class'] ?? 'form_label' }}">
      {{ $label['text'] }}
  </label>
  @endisset

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
    <div class="help">{{ $help }}</div>
  @endisset

  {{-- FORM ERRORS --}}
  @foreach ($errors as $error)
    <div class="form_error" role="alert">{{ $error }}</div>
  @endforeach
</div>