@extends('layouts.pagewrapper')

@section('title', 'Edit Group')

@section('content')
<article id="maincontent">
  <div class="card">

    <div class="card_section card_section-title">
      {{ Breadcrumbs::render('groups.edit', $group) }}

      <h1 class="title">
        <span class="icon">@materialicon('settings')</span>
        <span>@lang('pages.groups.edit.title')</span>
      </h1>

      <div class="subtitle">@lang('pages.groups.edit.subtitle')</div>
    </div>

    <form action="{{ route('groups.update', ['group'=>$group]) }}" class="form card_section card_section-form" method="POST">
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
          'old' => old('name', $group->name)
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
            'old' => old('avatar_url', $group->avatar_url),
            'value' => $group->avatar_url,
            'default_image' => '/img/default_user_avatar.jpg',
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
          'old' => old('header_url', $group->header_url),
          'value' => $group->header_url,
          'default_image' => '/img/default_group_avatar.jpg',
          'directory' => 'default_headers'
        ],
        'images' => $header_images,
        'help' => 'Select a banner image for the group.',
        'errors' => $errors->get('header_url')
      ])

      {{-- Update Comment --}}
      @include('partials.form_inline_group', [
        'label' => ['text' => 'Update Comment'],
        'input' => [
          'name' => 'update_comment',
          'type' => 'textarea',
          'id' => 'update_comment',
          'class' => 'form_input form_input-small',
          'placeholder' => 'Leave a comment about your update...',
          'old' => old('update_comment')
        ],
        'icon' => [
          'align' => 'left',
          'name' => 'comment-outline'
        ],
        'help' => 'Optionally leave a comment describing your update.',
        'errors' => $errors->get('update_comment')
      ])

      <div class="form_footer">
        <button type="submit" class="button button-link">
          <span class="icon">@materialicon('check')</span>
          <span>Update Group</span>
        </button>
      </div>

    </form>

  </div>
</article>

@endsection

@section('sidebars')
{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection