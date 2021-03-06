@extends('layouts.pagewrapper')

@section('title', 'Edit Event')

@section('content')
<article id="maincontent">
  <div class="card">
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.events.delete', $event->group, $event) }}
      <h1 class="title">
        <span class="icon">@materialicon('delete')</span>
        <span>@lang('pages.events.delete.title')</span>
      </h1>
    </div>
    
    <form action="{{ route('events.destroy', ['event'=>$event]) }}" id="event_form" class="form card_section card_section-form" method="POST">
      @method('DELETE')
      @csrf

      {{--Event Details--}}
      <div class="form_section form_section-top event_card">

        <div class="form_sub_header">
          <h1 class="sub_title">Event Details</h1>
        </div>

        {{-- Event Title --}}
        <h1 class="event_title">{{ $event->name }}</h1>
  
        {{-- Event Date --}}
        <div class="event_date event_detail">
          <span class="icon icon-full_size">@materialicon('calendar')</span>
          <div class="detail_content">
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
          <div class="detail_content">
            <a href="{{ route('groups.view', ['group'=>$event->group]) }}">{{ $event->group->name }}</a>
            <small>
              <div class="seperated_count">
                <span>{{ $event->going_attendees_count }} Going</span>
                <span>{{ $event->interested_attendees_count }} Interested</span>
              </div>
            </small>
          </div>
        </div>

      </div>

      <div class="form_section event_card">
        
          <div class="event_card_section-description">

              {{-- Event Description --}}
              @isset($event->description)
              <div class="description">
                {{ $event->description }}
              </div>
              @endisset
    
              <dl class="event_description_list">
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

      <h2 class="form_confirmation">
        Are you sure you want to <strong>delete</strong> this event?<small>Note: The event will be permanently deleted.</small>
      </h2>

      <div class="form_footer">

        <button type="submit" class="button button-danger">
          <span class="icon">@materialicon('delete')</span>
          <span>Yes, Delete Event</span>
        </button>
        <a href="{{ route('groups.events.view', ['event'=>$event, 'group'=>$event->group]) }}" class="button button-cancel">
          <span class="icon">@materialicon('cancel')</span>
          <span>Cancel</span>
        </a>
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