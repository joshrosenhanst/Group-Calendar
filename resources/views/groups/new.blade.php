@extends('layouts.pagewrapper')

@section('title', 'New Group')

@section('content')
<article id="maincontent">
  <div class="card">

    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.new') }}

      <h1 class="title">
        <span class="icon">@materialicon('plus-circle')</span>
        <span>@lang('pages.groups.new.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.groups.new.subtitle')</div>
    </div>

    <form action="{{ route('groups.create') }}" class="form card_section card_section-form" method="POST">
      @method('PUT')
      @csrf

      {{-- Name --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Group Name'],
        'input' => [
          'name' => 'name',
          'type' => 'text',
          'id' => 'name',
          'placeholder' => 'Group Name',
          'required' => true,
          'old' => old('name')
        ],
        'errors' => $errors->get('name')
      ])
      
      {{-- Avatar Image Selection --}}
      <div class="avatar_selection_display">
        @include('partials.form_inline_image_selection', [
          'label' => [
            'text' => 'Avatar Image',
            'button' => 'Select a Group Avatar Image'
          ],
          'input' => [
            'name' => 'avatar_url',
            'id' => 'avatar_url',
            'old' => old('avatar_url'),
            'value' => null,
            'default_image' => asset('/img/default_user_avatar.jpg'),
            'directory' => 'default_avatars'
          ],
          'images' => $avatar_images,
          'help' => 'Select an avatar image for the group.',
          'errors' => $errors->get('avatar_url')
        ])
      </div>
      
      {{-- Header Image Selection --}}
      @include('partials.form_inline_image_selection', [
        'label' => [
          'text' => 'Header Image',
          'button' => 'Select a Group Header Image'
        ],
        'input' => [
          'name' => 'header_url',
          'id' => 'header_url',
          'old' => old('header_url'),
          'value' => null,
          'default_image' => asset('/img/default_group_avatar.jpg'),
          'directory' => 'default_headers'
        ],
        'images' => $header_images,
        'help' => 'Select a banner image for the group.',
        'errors' => $errors->get('header_url')
      ])

      <div class="form_footer">
        <button type="submit" class="button button-link">
          <span class="icon">@materialicon('check')</span>
          <span>Create Group</span>
        </button>
      </div>

    </form>

  </div>
</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper id="sidebars" v-bind:active="navbarMenuActive">
  {{-- Groups Sidebar --}}
  @include('layouts.sidebar.groups')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection

@section('page_scripts')
  <script src="{{ asset(mix('/js/pages/groups/new.js')) }}"></script>
@endsection