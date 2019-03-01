@extends('layouts.landing')

@section('title', $event->name)

@section('content')
<article id="maincontent">
  <div class="card event_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('events.view', $event) }}
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
              <span v-if="going_attendees_count">@{{ going_attendees_count }} Going</span>
              <span v-if="interested_attendees_count">@{{ interested_attendees_count }} Interested</span>
            </a>
          </small>
        </div>
      </div>

      {{-- User Attendee Status --}}
      <attendee-status 
        v-bind:status="user_status"
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
        v-bind:attendees="attendees"
      ></attendees-card>
    </aside>
  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</aside>
@endsection

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    user: @json(Auth::user()),
    event: @json($event->id),
    user_status: @json($event->user_status),
    comments: @json($event->comments),
    going_attendees_count: @json($event->going_attendees_count),
    interested_attendees_count: @json($event->interested_attendees_count),
    attendees: @json($event->attendees)
  },
  methods: {
    updateStatus: function(status){
      axios.put(`/ajax/events/${this.event}/attend/`,{
        'status': status,
        'user_id': this.user.id
      }).then((response) => {
        this.user_status = response.data.user_status;
        this.going_attendees_count = response.data.going_attendees_count;
        this.interested_attendees_count = response.data.interested_attendees_count;
        this.attendees = response.data.attendees;
      }).catch((error) => {
        console.log(error);
      });
    },
    createComment: function(text){
      console.log("create comment",text,this.user.id);
      axios.put(`/ajax/events/${this.event}/comment/create`,{
        'text': text,
        'user_id': this.user.id
      }).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    updateComment: function(text,comment_id){
      axios.put(`/ajax/events/${this.event}/comment/${comment_id}/update`,{
        'text': text
      }).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteComment: function(comment_id){
      axios.delete(`/ajax/events/${this.event}/comment/${comment_id}/delete`).then((response) => {
        console.log(response);
        this.comments = response.data;
      }).catch((error) => {
        console.log(error);
      });
    }
  }
});
</script>
@endpush