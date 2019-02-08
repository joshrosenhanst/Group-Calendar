@switch($input['type'])
  @case('textarea')
    <textarea 
      @isset($input['id'])
      id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      name="{{ $input['name'] }}"
      @endisset
      @isset($input['placeholder'])
      placeholder="{{ $input['placeholder'] }}"
      @endisset
      class="{{ $input['class'] ?? 'form_input' }}"
  >{{ $input['old'] ?? null }}</textarea>
    @break

  @case('checkbox')
    <input
      @isset($input['id'])
      id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      name="{{ $input['name'] }}"
      @endisset
      type="checkbox"
      value="{{ $input['value'] }}"
      {{ (isset($input['old']) && $input['old'])?'checked':null }}
    >
    @break

  @case('text')
  @case('number')
  @case('password')
  @case('email')
  @default
    <input
      @isset($input['id'])
      id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      name="{{ $input['name'] }}"
      @endisset
      @isset($input['placeholder'])
      placeholder="{{ $input['placeholder'] }}"
      @endisset
      class="{{ $input['class'] ?? 'form_input' }}"
      type="{{ $input['type'] ?? 'text' }}"
      value="{{ $input['old'] ?? null }}"
    >
    @break
@endswitch