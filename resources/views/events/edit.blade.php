@extends('layouts.landing')

@section('title', 'Edit Event')

@section('content')
<article id="maincontent">
  <div class="card">
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.edit', $event->group, $event) }}
      <h1 class="title">Edit Event</h1>
    </div>
    
    <form action="{{ route('events.update', ['event'=>$event]) }}" id="event_form" class="form card_section card_section-form" method="POST">
      @method('PUT')
      @csrf
      
      {{-- Name --}}
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

      {{-- Group --}}
      @component('partials.form_inline_static', [
        'label' => ['text' => 'Group']
      ])

        <span class="preview_thumbnail">
          <img src="{{ asset($event->group->avatar) }}" alt="{{ $event->group->name }} Avatar">
        </span>
        <strong>{{ $event->group->name }}</strong>
      @endcomponent

      {{-- Start Date/Time --}}
      @include('partials.form_inline_group_multiple', [
        'label' => ['text' => 'Start Date','required'=>true,'label_for'=>'start_date'],
        'inputs' => [
          [
            'name' => 'start_date',
            'type' => 'date',
            'min' => '1/1/2019',
            'value' => \Carbon\Carbon::today()->toDateTimeString(),
            'id' => 'start_date',
            'old' => old( 'start_date', ( $event->start_date->toDateTimeString() ) ),
            'icon' => [
              'align' => 'left',
              'name' => 'calendar'
            ]
          ],
          [
            'name' => 'start_time',
            'type' => 'time',
            'id' => 'start_time',
            'old' => old('start_time', ( 
              $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : null
            )),
            'icon' => [
              'align' => 'left',
              'name' => 'clock-outline'
            ]
          ]
        ],
        'help' => 'Select a date from the calendar. The calendar shows dates with events in your groups. You can optionally add an end date and time.',
        'has_errors' => ( $errors->has('start_date') || $errors->has('start_time') ),
        'error_group' => [ $errors->get('start_date'), $errors->get('start_time') ]
      ])

      {{-- End Date/Time --}}
      <div class="form_group_wrapper" v-if="showEndDate">
        @include('partials.form_inline_group_multiple', [
          'label' => ['text' => 'End Date','label_for'=>'end_date'],
          'inputs' => [
            [
              'name' => 'end_date',
              'type' => 'date',
              'min' => '1/1/2019',
              'id' => 'end_date',
              'old' => old('end_date', ( 
                $event->end_date ? $event->end_date->toDateTimeString() : $event->start_date->toDateTimeString() 
              )),
              'icon' => [
                'align' => 'left',
                'name' => 'calendar'
              ]
            ],
            [
              'name' => 'end_time',
              'type' => 'time',
              'id' => 'end_time',
              'old' => old('end_time', (
                $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : null
              )),
              'icon' => [
                'align' => 'left',
                'name' => 'clock-outline'
              ]
            ]
          ],
          'has_errors' => ( $errors->has('end_date') || $errors->has('end_time') ),
          'error_group' => [ $errors->get('end_date'), $errors->get('end_time') ]
        ])
      </div>

      {{--Button prompt to show/hide the End Date fields --}}
      <div class="form_inline_group">
        <div class="field">
          <div class="field_label"></div>
          <div class="field_body">
            <button class="button button-small button-info"
              v-on:click.prevent="showEndDate = !showEndDate"
            >
              <material-icon v-bind:name="(showEndDate ? 'minus':'plus')"></material-icon>
              <span>@{{ showEndDate ? 'Remove':'Add' }} End Date</span>
            </button>
          </div>
        </div>
      </div>

      {{-- Description --}}
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

      {{-- Update Comment --}}
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

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Event Sidebar --}}
  @include('layouts.sidebar.event', ['event'=>$event])
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$event->group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

{{-- Include the page data variables injected by the controller and the page script which will create the Vue instance. --}}
@section('page_scripts')
  @include('partials.pagedata')
  <script src="{{ asset('/js/pages/events/edit.js') }}"></script>
@endsection