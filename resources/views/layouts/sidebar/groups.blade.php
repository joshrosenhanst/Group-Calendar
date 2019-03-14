@can('new',App\Group::class)
<div class="sidebar">
  
  <div class="sidebar_title">
    <h2 class="title">
      <span class="icon">@materialicon('account-group')</span>
      <span>@lang('pages.groups.index.title')</span>
    </h2>
  </div>

  <div class="sidebar_section sidebar_links">
    <a href="{{ route('groups.new') }}" class="sidebar_link">
      <span class="icon">@materialicon('plus-circle')</span>
      <span>Create New Group</span>
    </a>
  </div>
  
</div>
@endcan