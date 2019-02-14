@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  {{ Breadcrumbs::render('groups.view', $group) }}
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
  @include('blocks.groups.upcoming_events')
  <div class="maincontent_container">
    <div class="maincontent_mid_section">
      @include('blocks.groups.latest_comments')
    </div>
    <aside class="maincontent_aside">
      @include('blocks.groups.recent_members')
    </aside>
  </div>
</article>
@include('layouts.sidebar', ['group_selected'=>$group])
@endsection