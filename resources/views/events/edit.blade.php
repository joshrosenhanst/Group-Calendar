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
        'errors' => $errors->get('name')
      ])
      @include('partials.form_inline_static', [
        'label' => ['text' => 'Group'],
        'icon' => [
          'align' => 'left',
          'name' => 'account-multiple'
        ],
        'slot' => $event->group->name
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
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Update Comment'],
        'input' => [
          'name' => 'update_comment',
          'type' => 'textarea',
          'id' => 'update_comment',
          'class' => 'form_input form_input-small',
          'placeholder' => 'Leave a comment about your update...',
          'old' => old('update_comment')
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'comment-outline'
        ],
        'help' => 'Optionally leave a comment describing your update.',
        'errors' => $errors->get('update_comment')
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