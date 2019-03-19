@extends('layouts.pagewrapper')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.view', $event->group,$event) }}

      @if(session('status'))
        <status-alert class="alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <strong>Note: </strong> {{ session('status') }}
        </status-alert>
      @endif

    </div>
    {{-- Event Details --}}
    <div class="card_section card_section-background_image" style="background-image:url({{ asset($event->header) }})"></div>
    <div class="card_section event_card_section-main">
      {{-- Event Title --}}
      <h1 class="event_title">{{ $event->name }}</h1>

      {{-- Event Date --}}
      <div class="event_date event_detail">
        <span class="icon icon-full_size">@materialicon('calendar')</span>
        <div class="detail_content detail_content-mid">
          {{ $event->summary_date }}
        </div>
      </div>

      @if($event->location_place_id)
      {{-- Event Location --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('map-marker')</div>
        <div class="detail_content">
          <div class="event_location_name">{{ $event->location_name }}</div>
          <div class="event_location_address">{{ $event->location_formatted_address }}</div>
          @if($event->location_map_url)
          <a class="event_location_url" href="{{ $event->location_map_url }}" target="_blank">
            <span class="icon is-small">@materialicon('google-maps')</span>
            <span>Open Location in Google Maps</span>
          </a>
          @endif
        </div>
      </div>
      @endif

      {{-- Event Group and Attendee count --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('account-group')</div>
        <div class="detail_content"
          v-bind:class="{ 'detail_content-mid': !(event.going_attendees_count || event.interested_attendees_count) }"
        >
          <a href="{{ route('groups.view', ['group'=>$event->group]) }}">{{ $event->group->name }}</a>
          <small>
            <a href="#attendees" class="seperated_count" title="View Event Attendees">
              <span v-if="event.going_attendees_count">@{{ event.going_attendees_count }} Going</span>
              <span v-if="event.interested_attendees_count">@{{ event.interested_attendees_count }} Interested</span>
            </a>
          </small>
        </div>
      </div>

      @if($event->flyer_url || $event->flyer_processing)
      {{-- Event Flyer Link --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('file-download')</div>
        <div class="detail_content detail_content-mid">

          <div class="loading_text"
            v-if="event.flyer_processing"
          >
            <span class="icon is-loading"></span> Loading Event Flyer PDF...
          </div>
          <template v-else>
            <a download="GroupCalendar Event Flyer.pdf" 
              v-if="event.flyer_url"
              :href="'/storage/flyers/' + event.flyer_url"
            >Download Event Flyer PDF</a>
          </template>

        </div>
      </div>
      @endif

      {{-- User Attendee Status --}}
      <attendee-status 
        v-bind:status="event.user_status"
        v-on:update="updateStatus"
      ></attendee-status>
    </div>

    @if($event->description)
    <div class="card_section event_card_section-description">
        {{-- Event Description --}}
        <div class="event_detail">
          <div class="icon icon-full_size">@materialicon('text')</div>
          <div class="detail_content">
            {!! nl2br(e($event->description)) !!}
          </div>
        </div>
    </div>
    @endif

    <div class="card_section event_card_section-description">

      {{-- Event Creator / Link --}}
      <dl class="event_description_list">

        {{--Event Link --}}
        <div class="description_list_group">
          <dt>Event Link</dt>
          <dd>
            <a href="{{ route('events.view', ['event'=>$event]) }}">{{ route('events.view', ['event'=>$event]) }}</a>
          </dd>
        </div>

        {{--Created At timestamp --}}
        <div class="description_list_group">
          <dt>Created</dt>
          <dd>
            <span class="description_timestamp">{{ $event->created_at->format('m/d/Y h:i A') }}</span> by <a href="{{ route('users.view', ['user'=>$event->creator]) }}">{{ $event->creator->name }}</a>
          </dd>
        </div>

        {{--Updated At timestamp --}}
        @if($event->edited && $event->updater)
        <div class="description_list_group">
          <dt>Updated</dt>
          <dd>
            <span class="description_timestamp">{{ $event->updated_at->format('m/d/Y h:i A') }}</span> by <a href="{{ route('users.view', ['user'=>$event->updater]) }}">{{ $event->updater->name }}</a>
          </dd>
        </div>
        @endif

      </dl>
    </div>
  </div>

  {{-- Additional info cards --}}
  <div class="maincontent_container">

    <div class="maincontent_mid_section">
      {{-- Event Comments --}}
      <comments-card
        v-bind:comments="comments"
        v-bind:user="user"
        v-bind:user_admin="@json(Auth::user()->can('manageComments', $event->group))"

        v-on:create-comment="createComment"
        v-on:update-comment="updateComment"
        v-on:delete-comment="deleteComment"
      ></comments-card>
    </div>

    <aside class="maincontent_aside">
      {{-- Event Attendees --}}
      <attendees-card
        v-bind:attendees="event.attendees"
      ></attendees-card>
    </aside>
  </div>
</article>

@endsection

@section('sidebars')
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
  <script src="{{ asset('/js/pages/events/view.js') }}"></script>
@endsection