@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <header class="maincontent_header card" style="background-image: url({{ asset($group->avatar) }})">
    <div class="maincontent_avatar_container">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="maincontent_header_avatar">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </a>
      <div class="maincontent_header_details">
        <a href="{{ route('groups.view', ['group'=>$group]) }}" class="maincontent_header_name">{{ $group->name }}</a>
        <div class="maincontent_header_subtext">Created {{ $group->create_date }}</div>
      </div>
    </div>
  </header>
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      <div class="card card_events_list">
        <div class="card_header">
          <h2>
            <span class="icon">@materialicon('calendar-range')</span>
            <span>Upcoming Events</span></h2>
        </div>
        <div class="card_section">
          @include('events.upcoming', ['events'=>$events])
        </div>
        <div class="card_section card_buttons">
          <a href="{{ route('groups.events.new', ['group'=>$group]) }}" class="button button-text">
            <span class="icon">@materialicon('calendar-plus')</span>
            <span>Create New Event</span>
          </a>
          <a href="{{ route('groups.events', ['group'=>$group]) }}" class="button button-text">
            <span class="icon">@materialicon('calendar-range')</span>
            <span>View All Group Events</span>
          </a>
        </div>
      </div>

      <div class="card">
        <div class="card_header">
          <h2>
            <span class="icon">@materialicon('comment-multiple')</span>
            <span>Latest Comments</span>
          </h2>
        </div>
        <div class="card_section">
          @include('comments.list', ['comments'=>$comments])
        </div>
      </div>
    </div>
    <aside class="maincontent_aside">
      <div class="card card_members_list">
        <div class="card_header">
          <h2>
            <span class="icon">@materialicon('account-multiple')</span>
            <span>Recently Added Members</span>
          </h2>
        </div>
        <div class="card_section card_list">
          @include('members.list', ['users'=>$group->users->sortByDesc('created_at')->take(5)])
        </div>
        <div class="card_section card_buttons">
          <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button button-text">View All Members</a>
        </div>
      </div>
    </aside>
  </div>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection