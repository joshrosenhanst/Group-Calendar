<div class="sidebar">
  <div class="sidebar_header sidebar_header-no_content"></div>
  <div class="sidebar_header">
    <h1 class="title">
      <span class="icon">@materialicon('account-box')</span>
      <span>My Profile</span>
    </h1>
  </div>
  <div class="sidebar_section sidebar_links">
    <a href="{{ route('profile.edit') }}" class="sidebar_link">
      <span class="icon">@materialicon('pencil')</span>
      <span>Edit Profile</span>
    </a>
    <a href="{{ route('profile.password') }}" class="sidebar_link">
      <span class="icon">@materialicon('pencil-lock')</span>
      <span>Change Password</span>
    </a>
  </div>
  <div class="sidebar_footer sidebar_footer-no_content"></div>
</div>