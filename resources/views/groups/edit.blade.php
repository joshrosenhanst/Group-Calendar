@extends('layouts.landing')

@section('title', 'Edit Group')

@section('content')
<article id="maincontent">
  <div class="card">

  <div class="card_header card_header-no_content"></div>
  <div class="card_section card_section-title">
    {{ Breadcrumbs::render('groups.edit', $group) }}

    <h1 class="title">
      <span class="icon">@materialicon('pencil')</span>
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

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Group Sidebar --}}
  @include('layouts.sidebar.group', ['group'=>$group])
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection