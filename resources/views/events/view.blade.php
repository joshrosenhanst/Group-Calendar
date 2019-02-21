@extends('layouts.landing')

@section('title', $event->name)

@section('content')
@materialicon('pencil')
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
          <a href="#">1256 Franklin St<small>Brooklyn, NY 07747</small></a>
        </div>
      </div>

      {{-- Event Group and Attendee count --}}
      <div class="event_detail">
        <div class="icon icon-full_size">@materialicon('account-group')</div>
        <div class="detail_content">
          <a href="#attendees">{{ $event->group->name }}
            <small class="seperated_count">
              @if($event->going_attendees_count)
                <span>{{ $event->going_attendees_count }} Going</span>
              @endif
              @if($event->interested_attendees_count)
               <span>{{ $event->interested_attendees_count }} Interested</span>
              @endif
            </small>
          </a>
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
      <div class="description">
        {{ $event->description }}
      </div>

      {{-- Event Creator / Link --}}
      <dl class="event_description_list">
        <div class="description_list_group">
          <dt>Created By</dt>
          <dd>
            <a href="{{ route('users.view', ['user'=>$event->creator]) }}">{{ $event->creator->name }}</a>
          </dd>
        </div>
        <div class="description_list_group">
          <dt>Event Link</dt>
          <dd>
            <a href="{{ route('events.view', ['event'=>$event]) }}">{{ route('events.view', ['event'=>$event]) }}</a>
          </dd>
        </div>
      </dl>
    </div>
  </div>

  {{-- Additional info cards --}}
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      {{-- Event Comments --}}
      {{--@include('blocks.events.comments', ['comments'=>$event->comments])--}}
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
      @include('blocks.events.attendees', ['attendees'=>$event->attendees])
    </aside>
  </div>
</article>
@include('layouts.sidebar')
@endsection

@push('scripts')
<script>
const app = new Vue({
  el: '#app',
  data: {
    user: @json(Auth::user()),
    event: @json($event->id),
    user_status: @json($user_status),
    comments: @json($event->comments)
  },
  methods: {
    updateStatus: function(status){
      console.log("update status", status);
      axios.put(`/ajax/events/${this.event}/attend/`,{
        'status': status,
        'user_id': this.user.id
      }).then((response) => {
        console.log(response);
        this.user_status = response.data;
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