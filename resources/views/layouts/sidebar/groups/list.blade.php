<div class="sidebar">
  <div class="sidebar_header">
    <h1>My Groups</h1>
  </div>
  <div class="sidebar_section sidebar_links">
    @each('layouts.sidebar.groups.link', $groups, 'group', 'layouts.sidebar.groups.empty')
  </div>
</div>