@extends('layouts.landing')

@section('title', 'New Event')

@section('content')
<article id="maincontent">
  <div class="card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.new') }}
      <h1 class="title">New Event</h1>
    </div>
    <form action="{{ route('events.create') }}" id="event_form" class="form card_section card_section-form" method="POST">
      @method('PUT')
      @csrf
      
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Event Name'],
        'input' => [
          'name' => 'name',
          'type' => 'text',
          'id' => 'name',
          'placeholder' => 'Event Name',
          'required' => true,
          'old' => old('name')
        ],
        'help' => 'This is a help block',
        'errors' => $errors->get('name')
      ])
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Group'],
        'input' => [
          'name' => 'group',
          'type' => 'select',
          'id' => 'group',
          'placeholder' => 'Group',
          'required' => true,
          'default_option' => 'Select a Group',
          'options' => Auth::user()->group_select,
          'old' => old('group', request('group'))
        ],
        'help' => 'This is a help block',
        'errors' => $errors->get('group')
      ])
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Start Date'],
        'input' => [
          'name' => 'start_date',
          'type' => 'date',
          'value' => \Carbon\Carbon::today()->toDateString(),
          'min' => '2019-01-01',
          'id' => 'start_date',
          'required' => true,
          'old' => old('start_date')
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'calendar'
        ],
        'errors' => $errors->get('start_date')
      ])
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Start Time'],
        'input' => [
          'name' => 'start_time',
          'type' => 'time',
          'id' => 'start_time',
          'old' => old('start_time')
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'clock-outline'
        ],
        'errors' => $errors->get('start_time')
      ])
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Description'],
        'input' => [
          'name' => 'description',
          'type' => 'textarea',
          'id' => 'description',
          'placeholder' => 'Description',
          'old' => old('description')
        ],
        'errors' => $errors->get('description')
      ])

      <div class="form_footer">
        <button type="submit" class="button button-link">
          <span class="icon">@materialicon('calendar-check')</span>
          <span>Submit Event</span>
        </button>
      </div>
    </form>
  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection