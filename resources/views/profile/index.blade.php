@extends('layouts.landing')

@section('title', 'My Profile')

@section('content')
<article id="maincontent">
  <div class="card profile_card">
    {{-- Page Header --}}
    <div class="card_header card_header-no_content"></div>
    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('profile.index') }}
      <h1 class="title">
        <span class="icon">@materialicon('account-box')</span>
        <span>@lang('pages.profile.index.title')</span>
      </h1>
    </div>

    {{-- Profile Info --}}
    <div class="card_section">
      <dl class="description_list profile_description_list">

        <div class="description_list_group">
          <dt>Name</dt>
          <dd>{{ Auth::user()->name }}</dd>
        </div>
        
        <div class="description_list_group">
          <dt>Email</dt>
          <dd>{{ Auth::user()->email }}</dd>
        </div>
      
        <div class="description_list_group">
          <dt>Avatar</dt>
          <dd>
            <span class="preview_thumbnail profile_preview_thumbnail">
              <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
            </span> 
          </dd>
        </div>
              
      </dl>
    </div>
  </div>
</article>

{{-- Sidebars --}}
<aside id="sidebars">
    {{-- Profile Sidebar --}}
    @include('layouts.sidebar.profile')
    {{-- User Sidebar --}}
    @include('layouts.sidebar.user')
  </aside>
  @endsection
@endsection