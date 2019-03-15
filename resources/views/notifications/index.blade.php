@extends('layouts.pagewrapper')

@section('title', 'GroupCalendar Home')

@section('content')
<article id="maincontent">
  <div class="card">
    {{-- Page Header --}}
    
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('notifications.index') }}

      <h1 class="title">
        <span class="icon">@materialicon('bell')</span>
        <span>@lang('pages.notifications.index.title')</span>
      </h1>

    </div>

    <div class="card_section card_list">
      @if(Auth::user()->all_notifications->count())
        @foreach(Auth::user()->all_notifications as $notification)
          <div class="list_item">

            {{-- Notification Icon: defaults to `bell-alert` --}}
            <div class="item_icon">
              <span class="icon icon-full_size">
                @isset($notification->data['icon'])
                  @materialicon($notification->data['icon'])
                @else
                  @materialicon('bell-alert')
                @endisset
              </span>
            </div>

            {{-- Notification Details --}}
            <div class="item_details">

              @isset($notification->data['url'])
              <a href="{{ $notification->data['url'] }}" class="text">{!! $notification->data['text'] !!}</a>
              @else
              <div class="text">{!! $notification->data['text'] !!}</div>
              @endisset
              
              <div class="subtext">{{ $notification->created_at->diffForHumans() }}</div>

            </div>

          </div>
        @endforeach
      @else
        <div class="empty list_empty">
          <span class="icon">@materialicon('bell-outline')</span>
          <h2>No Notifications</h2>
        </div>
      @endif
    </div>
  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection