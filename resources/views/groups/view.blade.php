@extends('layouts.landing')

@section('title', $group->name)

@section('content')
<article id="maincontent">
  <div class="card">
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.view', $group) }}
    </div>
    @component('components.group.summary', ['group'=>$group])
      @slot('links')
        <div class="group_links button_group button_group-inverted button_group-link button_group-small">
            <a href="{{ route('events.new', ['group'=>$group]) }}" class="button">
              <span class="icon">@materialicon('calendar-plus')</span>
              <span>New Event</span>
            </a>
            <a href="{{ route('events.index', ['group'=>$group]) }}" class="button">
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
  </div>
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