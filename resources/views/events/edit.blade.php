@extends('layouts.pagewrapper')

@section('title', 'Edit Event')

@section('content')
<article id="maincontent">
  <div class="card">
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.edit', $event->group, $event) }}
      <h1 class="title">
        <span class="icon">@materialicon('pencil')</span>
        <span>@lang('pages.events.edit.title')</span>
      </h1>
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
      
      {{-- Location --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Event Location'],
        'input' => [
          'name' => 'locationpicker',
          'type' => 'location',
          'id' => 'locationpicker',
          'placeholder' => 'Event Location',
          'required' => true,
          'location' => old('location', $event->getLocationArray())
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'map-marker'
        ],
        'errors' => $errors->get('location')
      ])

      {{-- Start Date/Time --}}
      @include('partials.form_inline_group_multiple', [
        'label' => ['text' => 'Start Date','required'=>true,'label_for'=>'start_date'],
        'inputs' => [
          [
            'name' => 'start_date',
            'type' => 'date',
            'min' => '1/1/2019',
            'value' => \Carbon\Carbon::today()->toIso8601String(),
            'id' => 'start_date',
            'old' => strtotime(old('start_date', $event->start_date)) ? \Carbon\Carbon::parse( old('start_date', $event->start_date) )->toIso8601String() : null,
            'icon' => [
              'align' => 'left',
              'name' => 'calendar'
            ]
          ],
          [
            'name' => 'start_time',
            'type' => 'time',
            'id' => 'start_time',
            'old' => ( strtotime(old('start_time',$event->start_time)) ? \Carbon\Carbon::parse(old('start_time',$event->start_time))->format('H:i') : null ),
            'icon' => [
              'align' => 'left',
              'name' => 'clock-outline'
            ]
          ]
        ],
        'help' => 'Select a date from the calendar. The calendar shows dates with events in your groups.',
        'has_errors' => ( $errors->has('start_date') || $errors->has('start_time') ),
        'error_group' => [ $errors->get('start_date'), $errors->get('start_time') ]
      ])

      {{--Button prompt to show/hide the End Date fields. Hidden for noscript. --}}
      <template v-if="!showEndDate" style="display:none;">
      <div class="form_inline_group">
        <div class="field">
          <div class="field_label"></div>
          <div class="field_body">
            <button class="button button-small button-info"
              v-on:click.prevent="showEndDate = true"
              v-on:keyup.event.prevent="showEndDate = true"
              v-on:keyup.space.prevent="showEndDate = true"
            >
              <material-icon name="plus"></material-icon>
              <span>Add End Date</span>
            </button>
            <div class="form_help"> You can optionally add an end date and time for the event.</div>
          </div>
        </div>
      </div>
      </template>

      {{-- End Date/Time - Includes a button to remove the end date/time fields, which is hidden for noscript. --}}
      <div class="form_group_wrapper" v-if="showEndDate">
        @component('partials.form_inline_group_multiple', [
          'label' => ['text' => 'End Date','label_for'=>'end_date'],
          'inputs' => [
            [
              'name' => 'end_date',
              'type' => 'date',
              'min' => '1/1/2019',
              'id' => 'end_date',
              'old' => strtotime(old('end_date', ( $event->end_date ?? $event->start_date))) ? \Carbon\Carbon::parse( old('end_date', ( $event->end_date ?? $event->start_date)) )->toIso8601String() : null,
              'icon' => [
                'align' => 'left',
                'name' => 'calendar'
              ]
            ],
            [
              'name' => 'end_time',
              'type' => 'time',
              'id' => 'end_time',
              'old' => ( strtotime(old('end_time',$event->end_time)) ? \Carbon\Carbon::parse(old('end_time',$event->end_time))->format('H:i') : null ),
              'icon' => [
                'align' => 'left',
                'name' => 'clock-outline'
              ]
            ]
          ],
          'has_errors' => ( $errors->has('end_date') || $errors->has('end_time') ),
          'error_group' => [ $errors->get('end_date'), $errors->get('end_time') ]
        ])
          <template v-if="showEndDate" style="display:none;">
            <button class="action_icon action_icon-danger action_icon-mobile" aria-label="Remove End Date" title="Remove End Date"
              v-on:click.prevent="showEndDate = false"
              v-on:keyup.enter.prevent="showEndDate = false"
              v-on:keyup.space.prevent="showEndDate = false"
            >
              <span class="icon">@materialicon('close')</span>
              <span class="mobile_text">Remove End Date</span>
            </button>
          </template>
        @endcomponent
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
        'icon' => [
          'align' => 'left',
          'name' => 'text'
        ],
        'errors' => $errors->get('description')
      ])

      {{-- Header Image Selection --}}
      @include('partials.form_inline_image_selection', [
        'label' => [
          'text' => 'Header Image',
          'button' => 'Select an Event Header Image'
        ],
        'input' => [
          'name' => 'header_url',
          'id' => 'header_url',
          'old' => old('header_url', $event->header_url),
          'value' => $event->header_url,
          'default_image' => asset('/img/default_event_header.jpg'),
          'directory' => 'default_headers'
        ],
        'images' => $header_images,
        'help' => 'Select a banner image for the event.',
        'errors' => $errors->get('header_url')
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

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
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
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
  @include('partials.pagedata')
  <script src="{{ asset(mix('/js/pages/events/edit.js')) }}"></script>
@endsection