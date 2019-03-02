<?php
// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', route('home'));
});

/* PROFILE */
// My Profile
Breadcrumbs::for('profile.index', function ($trail) {
  $trail->push('My Profile', route('profile.index'));
});

// My Profile / Edit
Breadcrumbs::for('profile.edit', function ($trail) {
  $trail->push('Edit', route('profile.edit'));
});

// My Profile / Change Password
Breadcrumbs::for('profile.password', function ($trail) {
  $trail->push('Change Password', route('profile.password'));
});

/* GROUPS */
// My Groups
Breadcrumbs::for('groups.index', function ($trail) {
  $trail->push('My Groups', route('groups.index'));
});

// My Groups / New
Breadcrumbs::for('groups.new', function ($trail, $group) {
  $trail->parent('groups.index');
  $trail->push('New', route('groups.new'));
});

// My Groups / [group->title] / Edit
Breadcrumbs::for('groups.edit', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Edit', route('groups.edit', ['group'=>$group]));
});

// My Groups / [group->title]
Breadcrumbs::for('groups.view', function ($trail, $group) {
  $trail->parent('groups.index');
  $trail->push($group->name, route('groups.view', ['group'=>$group]));
});

// My Groups / [group->title] / Events
Breadcrumbs::for('groups.events.index', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Events', route('groups.events.index', ['group'=>$group]));
});

// My Groups / [group->title] / Events / New
Breadcrumbs::for('groups.events.new', function ($trail, $group) {
  $trail->parent('groups.events.index', $group);
  $trail->push('New', route('groups.events.new', ['group'=>$group]));
});

// My Groups / [group->title] / Events / [event->title]
Breadcrumbs::for('groups.events.view', function ($trail, $group, $event) {
  $trail->parent('groups.events.index', $group);
  $trail->push($event->name, route('groups.events.view', ['group'=>$group, 'event'=>$event]));
});

// My Groups / [group] / Events / [event->title] / Edit
Breadcrumbs::for('groups.events.edit', function ($trail, $group, $event) {
  $trail->parent('groups.events.view', $group, $event);
  $trail->push('Edit', route('groups.events.edit', ['event'=>$event,'group'=>$group]));
});

// My Groups / [group] / Events / [event->title] / Delete
Breadcrumbs::for('groups.events.delete', function ($trail, $group, $event) {
  $trail->parent('groups.events.view', $group, $event);
  $trail->push('Delete', route('groups.events.delete', ['event'=>$event,'group'=>$group]));
});

// My Groups / [group->title] / Members
Breadcrumbs::for('groups.members', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Members', route('groups.members', ['group'=>$group]));
});

/* Events */
// Events can optionally have a [group] prefix, if the group is set on the request
// Home / Events (no group)
// My Groups / [group] / Events
Breadcrumbs::for('events.index', function ($trail, $group=null) {
  if($group){
    $trail->parent('groups.view', $group);
    $trail->push('Events', route('groups.events.index', ['group'=>$group]));
  }else{
    $trail->parent('home');
    $trail->push('Events', route('events.index'));
  }
});
// Events / New (no group)
// My Groups / [group] / Events / New
Breadcrumbs::for('events.new', function ($trail, $group=null) {
  $trail->parent('events.index', $group);
  if($group){
    $trail->push('New', route('groups.events.new', $group));
  }else{
    $trail->push('New', route('events.new'));
  }
});