@extends('layouts.landing')

@section('title', 'New Group')

@section('content')
<article id="maincontent">
  <div class="card">

  <div class="card_header card_header-no_content"></div>
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

    <div class="form_footer">
      <button type="submit" class="button button-link">
        <span class="icon">@materialicon('check')</span>
        <span>Create Group</span>
      </button>
    </div>

  </form>

  </div>
</article>

{{-- Sidebars --}}
<sidebar-wrapper v-bind:active="navbarMenuActive">
  {{-- Groups Sidebar --}}
  @include('layouts.sidebar.groups')
  {{-- User Sidebar --}}
  @include('layouts.sidebar.user')
</sidebar-wrapper>
@endsection