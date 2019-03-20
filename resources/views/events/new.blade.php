@extends('layouts.pagewrapper')

@section('title', 'New Event')

@section('content')
<article id="maincontent">
  <div class="card">
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.new', $group) }}
      <h1 class="title">
        <span class="icon">@materialicon('calendar-plus')</span>
        <span>@lang('pages.events.new.title')</span>
      </h1>
    </div>
    
    <form action="{{ route('events.create') }}" id="event_form" class="form card_section card_section-form" method="POST">
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
          'old' => old('name')
        ],
        'errors' => $errors->get('name')
      ])

      {{-- Group --}}
      @if($group)
        @component('partials.form_inline_static', [
          'label' => ['text' => 'Group']
        ])
        <span class="preview_thumbnail">
          <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
        </span>
        <strong>{{ $group->name }}</strong>
        @endcomponent
        <input type="hidden" id="group" name="group" value="{{ $group->id }}">
      @else
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
          'icon' => [
            'align' => 'left',
            'name' => 'account-multiple'
          ],
          'errors' => $errors->get('group')
        ])
      @endif
      
      {{-- Location --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Event Location'],
        'input' => [
          'name' => 'locationpicker',
          'type' => 'location',
          'id' => 'locationpicker',
          'placeholder' => 'Event Location',
          'required' => true
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'map-marker'
        ],
        'help' => 'Search for the event location by name or address.',
        'errors' => $errors->get('location.place_id')
      ])

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
            'old' => \Carbon\Carbon::parse( old('start_date') )->toDateTimeString(),
            'icon' => [
              'align' => 'left',
              'name' => 'calendar'
            ]
          ],
          [
            'name' => 'start_time',
            'type' => 'time',
            'id' => 'start_time',
            'old' => ( old('start_time') ? \Carbon\Carbon::parse(old('start_time'))->format('H:i') : null ),
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

      {{-- End Date/Time --}}
      <div class="form_group_wrapper" v-if="showEndDate">
        @include('partials.form_inline_group_multiple', [
          'label' => ['text' => 'End Date','label_for'=>'end_date'],
          'inputs' => [
            [
              'name' => 'end_date',
              'type' => 'date',
              'min' => '1/1/2019',
              'value' => \Carbon\Carbon::today()->toDateTimeString(),
              'id' => 'end_date',
              'old' => \Carbon\Carbon::parse( old('end_date') )->toDateTimeString(),
              'icon' => [
                'align' => 'left',
                'name' => 'calendar'
              ]
            ],
            [
              'name' => 'end_time',
              'type' => 'time',
              'id' => 'end_time',
              'old' => ( old('start_time') ? \Carbon\Carbon::parse(old('start_time'))->format('H:i') : null ),
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
            <div class="form_help"> You can optionally add an end date and time for the event.</div>
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
          'old' => old('description')
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
          'old' => old('header_url'),
          'value' => null,
          'default_image' => asset('/img/default_event_header.jpg'),
          'directory' => 'default_headers'
        ],
        'images' => $header_images,
        'help' => 'Select a banner image for the event.',
        'errors' => $errors->get('header_url')
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

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  @if($group)
    {{-- Group Sidebar --}}
    @include('layouts.sidebar.group', ['group'=>$group])
  @endif
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

@section('page_scripts')
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
  @include('partials.pagedata')
  <script src="{{ asset(mix('/js/pages/events/new.js')) }}"></script>
@endsection