@switch($input['type'])
  @case('select')
    <div class="{{ $input['class'] ?? 'form_select' }}">
      <select
        @isset($input['id'])
        id="{{ $input['id'] }}"
        @endisset
        @isset($input['name'])
        name="{{ $input['name'] }}"
        @endisset
        @isset($input['placeholder'])
        placeholder="{{ $input['placeholder'] }}"
        @endisset
        @isset($input['aria-label'])
        aria-label="{{ $input['aria-label'] }}"
        @endisset
      >
        @isset($input['default_option'])
          <option>{{ $input['default_option'] }}</option>
        @endisset
        @isset($input['options'])
          @foreach($input['options'] as $option)
            <option 
              value="{{ $option['value'] }}"
              @if( isset($input['old']) && $input['old'] == $option['value'] )
              selected
              @endif
            >{{ $option['text'] }}</option>
          @endforeach
        @endisset
      </select>
    </div>
    @break

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
      @isset($input['aria-label'])
      aria-label="{{ $input['aria-label'] }}"
      @endisset
      class="{{ $input['class'] ?? 'form_input' }}"
  >{{ $input['old'] ?? $input['value'] ?? null }}</textarea>
    @break

  @case('checkbox')
    <input
      @isset($input['id'])
      id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      name="{{ $input['name'] }}"
      @endisset
      @isset($input['aria-label'])
      aria-label="{{ $input['aria-label'] }}"
      @endisset
      type="checkbox"
      value="{{ $input['value'] }}"
      {{ (isset($input['old']) && $input['old'])?'checked':null }}
    >
    @break

  @case('date')
    <app-datepicker
      @isset($input['id'])
      input_id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      input_name="{{ $input['name'] }}"
      @endisset
      @isset($input['placeholder'])
      input_placeholder="{{ $input['placeholder'] }}"
      @endisset
      @isset($input['min'])
      min-date="{{ $input['min'] }}"
      @endisset
      @isset($input['max'])
      max-date="{{ $input['max'] }}"
      @endisset
      @isset($input['aria-label'])
      input_label="{{ $input['aria-label'] }}"
      @endisset
      @isset($input['class'])
      input_class="{{ $input['class'] }}"
      @endisset
      value="{{ $input['old'] ?? $input['value'] ?? null }}"
      v-bind:events="(events || [])"
    ></app-datepicker>
    @break

  @case('time')
    <app-timepicker
      @isset($input['id'])
      input_id="{{ $input['id'] }}"
      @endisset
      @isset($input['name'])
      input_name="{{ $input['name'] }}"
      @endisset
      @isset($input['placeholder'])
      input_placeholder="{{ $input['placeholder'] }}"
      @endisset
      @isset($input['aria-label'])
      input_label="{{ $input['aria-label'] }}"
      @endisset
      @isset($input['class'])
      input_class="{{ $input['class'] }}"
      @endisset
      value="{{ $input['old'] ?? $input['value'] ?? null }}"
    ></app-timepicker>
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
      @isset($input['min'])
      min="{{ $input['min'] }}"
      @endisset
      @isset($input['max'])
      max="{{ $input['max'] }}"
      @endisset
      @isset($input['aria-label'])
      aria-label="{{ $input['aria-label'] }}"
      @endisset
      class="{{ $input['class'] ?? 'form_input' }}"
      type="{{ $input['type'] ?? 'text' }}"
      value="{{ $input['old'] ?? $input['value'] ?? null }}"
    >
    @break
@endswitch

@isset($icon)
  <span class="icon">@materialicon($icon['name'])</span>
@endisset