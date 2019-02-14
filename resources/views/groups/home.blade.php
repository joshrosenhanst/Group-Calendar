@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <header class="card group_summary" style="background-image: url({{ asset($group->avatar) }})">
    <div class="card_section group_avatar_container">
      <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_avatar_image">
        <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }} Avatar">
      </a>
      <div class="group_details">
          <a href="{{ route('groups.view', ['group'=>$group]) }}" class="group_name">{{ $group->name }}</a>
          <div class="group_subtext"><strong>{{ trans_choice('messages.member_count',$group->users_count) }}</strong> | Created {{ $group->create_date }}</div>
      </div>
      <div class="group_links button_group button_group-inverted button_group-link button_group-small">
        <a href="{{ route('groups.events.new', ['group'=>$group]) }}" class="button">
          <span class="icon">@materialicon('calendar-plus')</span>
          <span>New Event</span>
        </a>
        <a href="{{ route('groups.events', ['group'=>$group]) }}" class="button">
          <span class="icon">@materialicon('calendar-range')</span>
          <span>Group Events</span>
        </a>
        <a href="{{ route('groups.members', ['group'=>$group]) }}" class="button">
          <span class="icon">@materialicon('account-group')</span>
          <span>Group Members</span>
        </a>
      </div>
    </div>
  </header>
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      <div class="card">
        <div class="card_header">
          <h2>
            <span class="icon">@materialicon('calendar-range')</span>
            <span>Upcoming Events</span></h2>
        </div>
        <div class="card_section upcoming_events_section">
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
            <span>Recent Members</span>
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