@extends('layouts.landing')

@section('title', 'Edit Event')

@section('content')
<article id="maincontent">
  <div class="card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.edit', $event) }}
      <h1 class="title">Edit Event</h1>
    </div>
    <form action="{{ route('events.update', ['event'=>$event]) }}" id="event_form" class="form card_section card_section-form" method="POST">
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
          'old' => old('name', $event->name)
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
          'selected' => 1,
          'old' => old('group', $event->group_id)
        ],
        'help' => 'This is a help block',
        'errors' => $errors->get('name')
      ])
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Start Date'],
        'input' => [
          'name' => 'start_date',
          'type' => 'date',
          'min' => '2019-01-01',
          'id' => 'start_date',
          'required' => true,
          'old' => old('start_date', ($event->start_date->format('Y-m-d') ?? \Carbon\Carbon::today()->toDateString()))
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
          'old' => old('start_time', $event->start_time)
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
          'old' => old('description', $event->description)
        ],
        'errors' => $errors->get('description')
      ])

      <div class="form_footer">
        <button type="submit" class="button button-link">
          <span class="icon">@materialicon('calendar-check')</span>
          <span>Update Event</span>
        </button>
      </div>
    </form>
  </div>
</article>
@include('layouts.sidebar')
@endsection