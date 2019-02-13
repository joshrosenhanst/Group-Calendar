<div class="{{ $errors?'form_group form_group_checkbox form_group-error':'form_group form_group_checkbox'}}">
    @isset($label)
    <label class="{{ $label['class'] ?? 'form_label form_checkbox' }}">
      @include('partials.input', ['input' => $input])
      <span class="checkbox_text">{{ $label['text'] }}</span>
    </label>
    @endisset
    @foreach ($errors as $error)
      <div class="form_error" role="alert">{{ $error }}</div>
    @endforeach
  </div>