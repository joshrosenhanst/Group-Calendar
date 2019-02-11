<aside id="sidebar">
  @isset($group_selected)
    @include('layouts.sidebar.group', ['group'=>$group_selected])
  @else
    @include('layouts.sidebar.groups.list', ['groups'=>Auth::user()->groups])
  @endisset
  {{--if the user has any invites: include invites alert--}}
  @include('layouts.sidebar.user')
</aside>