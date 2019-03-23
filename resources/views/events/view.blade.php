@extends('layouts.pagewrapper')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.view', $event->group,$event) }}

      @if(session('status'))
        <status-alert class="alert alert-info" icon="alert-circle"
          v-bind:close-button="true"
        >
          <div class="alert_text">
            <strong>Note: </strong> {{ session('status') }}
          </div>
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

      @if($event->location_place_id || $event->location_name || $event->location_formatted_address || $event->location_city || $event->location_state)
      {{-- Event Location --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('map-marker')</div>
        <div class="detail_content">
          @if($event->location_name)
          <div class="event_location_name">{{ $event->location_name }}</div>
          @endif
          @if($event->location_formatted_address)
          <div class="event_location_address">{{ $event->location_formatted_address }}</div>
          @endif
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
              {{-- Noscript: the attendees counts are replaced via v-text with live counts if JS is on. --}}
              <span v-if="event.going_attendees_count" v-text="(event.going_attendees_count + ' Going')">{{ $event->going_attendees_count }} Going</span>
              <span v-if="event.interested_attendees_count" v-text="(event.interested_attendees_count + ' Interested')">{{ $event->interested_attendees_count }} Interested</span>
            </a>
          </small>
        </div>
      </div>

      @if($event->flyer_url || $event->flyer_processing)
      {{-- Event Flyer Link --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('file-download')</div>
        <div class="detail_content detail_content-mid">
          {{-- Noscript: show download link if its available, otherwise show 'flyer being processed' text that is overridden by v-text when JS is on. --}}
          @if($event->flyer_processing)
            <div class="loading_text"
              v-if="event.flyer_processing"
            >
              <span class="icon is-loading"></span>
              <span v-text="'Loading Event Flyer PDF...'">The Event Flyer PDF is being processed. You can refresh the page to check if is available.</span>
            </div>
            <template v-else style="display: none;">
              <a download="GroupCalendar Event Flyer.pdf" 
                v-if="event.flyer_url"
                :href="asset_url + '/storage/flyers/' + event.flyer_url"
              >Download Event Flyer PDF</a>
            </template>
          @else
          <a download="GroupCalendar Event Flyer.pdf" href="{{ asset($event->flyer) }}">Download Event Flyer PDF</a>
          @endif

        </div>
      </div>
      @endif

      {{-- User Attendee Status --}}
      <div is="attendee-status"
        v-bind:status="event.user_status"
        v-on:update="updateStatus"
      >

        {{-- Noscript: fallback when JS is unavailable - Show the user status (if set) and show a change status form if not set or `change_status` is set on the request. --}}
        <div id="attendee_controls">
          @if($event->user_status)
            <div class="event_detail {{ $event->user_status }}">
              <span class="icon icon-full_size" aria-label="My Attendee Status">@materialicon(trans('status.attendee.icon.'.$event->user_status))</span>
              <div class="detail_content">
                {{ trans('status.attendee.'.$event->user_status) }}
                <small>
                  <a class="button button-text button-inline" href="{{ route('groups.events.view', ['event'=>$event,'group'=>$event->group,'change_status'=>true]) }}">Change My Status</a>
                </small>
              </div>
            </div>
          @endif
          @if(request('change_status') || !$event->user_status)
            <form action="{{ route('events.attend', ['event'=>$event]) }}" method="POST">
              @method('PUT')
              @csrf

              <div class="attend_buttons button_group" aria-label="Change My Status">
                
                <button type="submit" class="button button-success button-inverted" name="status" value="going">
                  <span class="icon">@materialicon('account-check')</span>
                  <span>Going</span>
                </button>

                <button type="submit" class="button button-info button-inverted" name="status" value="interested">
                  <span class="icon">@materialicon('star')</span>
                  <span>Interested</span>
                </button>

                <button type="submit" class="button button-danger button-inverted" name="status" value="unavailable">
                  <span class="icon">@materialicon('account-remove')</span>
                  <span>Unavailable</span>
                </button>
              </div>
            </form>
          @else

          @endif
        </div>

      </div>

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
            <a class="event_link" href="{{ route('events.view', ['event'=>$event]) }}">{{ route('events.view', ['event'=>$event]) }}</a>
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
        v-bind:asset_url="asset_url"

        v-on:create-comment="createComment"
        v-on:update-comment="updateComment"
        v-on:delete-comment="deleteComment"
      >
        {{--Noscript: fallback to display the simple list of comments and comment form --}}
        @include('blocks.comments.list', [
          'comments' => $event->comments,
          'title' => 'Comments',
          'form_url' => route('events.createComment', ['event'=>$event]),
          'errors' => $errors->all()
        ])
      </comments-card>
    </div>

    <aside class="maincontent_aside">
      {{-- Event Attendees --}}
      <attendees-card
        v-bind:attendees="event.attendees"
        v-bind:asset_url="asset_url"
      >
        @include('blocks.attendees.list', [
          'attendees' => $event->attendees
        ])
      </attendees-card>
    </aside>
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
  @include('partials.pagedata')
  <script src="{{ asset(mix('/js/pages/events/view.js')) }}"></script>
@endsection