@extends('layouts.landing')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
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
        <div class="detail_content">
          {{ $event->summary_date }}
        </div>
      </div>

      {{-- Event Location --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('map-marker')</div>
        <div class="detail_content">
          <a href="#" title="View Location Map">1256 Franklin St<small>Brooklyn, NY 07747</small></a>
        </div>
      </div>

      {{-- Event Group and Attendee count --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('account-group')</div>
        <div class="detail_content">
          <a href="{{ route('groups.view', ['group'=>$event->group]) }}">{{ $event->group->name }}</a>
          <small>
            <a href="#attendees" class="seperated_count" title="View Event Attendees">
              <span v-if="event.going_attendees_count">@{{ event.going_attendees_count }} Going</span>
              <span v-if="event.interested_attendees_count">@{{ event.interested_attendees_count }} Interested</span>
            </a>
          </small>
        </div>
      </div>

      {{-- User Attendee Status --}}
      <attendee-status 
        v-bind:status="event.user_status"
        v-on:update="updateStatus"
      ></attendee-status>
    </div>
    <div class="card_section event_card_section-description">

      {{-- Event Description --}}
      @isset($event->description)
      <div class="description">
        {{ $event->description }}
      </div>
      @endisset

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
        @if($event->edited)
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