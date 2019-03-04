<div class="sidebar">
    <div class="sidebar_header sidebar_header-no_content"></div>
    <div class="sidebar_title">
      <h1 class="title">
        <span class="icon">@materialicon('account-multiple')</span>
        <span>@lang('pages.groups.members.title')</span>
      </h1>
    </div>
    <div class="sidebar_section sidebar_links">
      <a href="{{ route('groups.invite', ['group'=>$group]) }}" class="sidebar_link">
        <span class="icon">@materialicon('plus-circle')</span>
        <span>Invite New Member</span>
      </a>
    </div>
    <div class="sidebar_footer sidebar_footer-no_content"></div>
  </div>