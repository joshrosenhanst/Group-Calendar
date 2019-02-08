
<div class="{{ $errors?'form_group form_group-error':'form_group'}}">
  <label
    @isset($input['id'])
    for="{{ $input['id'] }}"
    @endisset
    class="{{ $label['class'] ?? 'form_label' }}">
      {{ $label['text'] }}
  </label>
  @include('partials.input', ['input' => $input])
  @foreach ($errors as $error)
    <div class="form_error" role="alert">{{ $error }}</div>
  @endforeach
</div>