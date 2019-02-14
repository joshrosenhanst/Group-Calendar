@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  @component('components.group.summary', ['group'=>$group])
    @slot('links')
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
            <span class="icon">@materialicon('account-multiple')</span>
            <span>Group Members</span>
          </a>
        </div>
    @endslot
  @endcomponent
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      @include('blocks.group.upcoming_events')
      @include('blocks.group.latest_comments')
    </div>
    <aside class="maincontent_aside">
      @include('blocks.group.recent_members')
    </aside>
  </div>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection