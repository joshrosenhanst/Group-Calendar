<div class="{{ $errors?'form_group form_group-error':'form_group'}}">
    <label class="{{ $label['class'] ?? 'form_label form_checkbox' }}">
      @include('partials.input', ['input' => $input])
      {{ $label['text'] }}
    </label>
    @foreach ($errors as $error)
      <div class="form_error" role="alert">{{ $error }}</div>
    @endforeach
  </div>