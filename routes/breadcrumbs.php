<?php
// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', route('home'));
});

/* PROFILE */
// Home / Edit Profile
Breadcrumbs::for('profile.edit', function ($trail) {
  $trail->parent('home');
  $trail->push('Edit Profile', route('profile.edit'));
});

// Home / Change Password
Breadcrumbs::for('profile.password', function ($trail) {
  $trail->parent('home');
  $trail->push('Change Password', route('profile.password'));
});

/* NOTIFICATIONS */
Breadcrumbs::for('notifications.index', function ($trail) {
  $trail->parent('home');
  $trail->push('Notifications', route('notifications.index'));
});

/* USERS */
// Home / [user->name]
Breadcrumbs::for('users.view', function ($trail, $user) {
  $trail->parent('home');
  $trail->push($user->name, route('users.view', ['user'=>$user]));
});

/* GROUPS */
// My Groups
Breadcrumbs::for('groups.index', function ($trail) {
  $trail->parent('home');
  $trail->push('My Groups', route('groups.index'));
});

// Home / New Group
Breadcrumbs::for('groups.new', function ($trail) {
  $trail->parent('home');
  $trail->push('New Group', route('groups.new'));
});

// Home / [group->title]
Breadcrumbs::for('groups.view', function ($trail, $group) {
  $trail->parent('home');
  $trail->push($group->name, route('groups.view', ['group'=>$group]));
});

// Home / [group->title] / Edit
Breadcrumbs::for('groups.edit', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Edit', route('groups.edit', ['group'=>$group]));
});

// Home / [group->title] / Events
Breadcrumbs::for('groups.events.index', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Events', route('groups.events.index', ['group'=>$group]));
});

// Home / [group->title] / Events / New Event
Breadcrumbs::for('groups.events.new', function ($trail, $group) {
  $trail->parent('groups.events.index', $group);
  $trail->push('New Event', route('groups.events.new', ['group'=>$group]));
});

// Home / [group->title] / Events / [event->title]
Breadcrumbs::for('groups.events.view', function ($trail, $group, $event) {
  $trail->parent('groups.events.index', $group);
  $trail->push($event->name, route('groups.events.view', ['group'=>$group, 'event'=>$event]));
});

// Home / [group] / Events / [event->title] / Edit
Breadcrumbs::for('groups.events.edit', function ($trail, $group, $event) {
  $trail->parent('groups.events.view', $group, $event);
  $trail->push('Edit', route('groups.events.edit', ['event'=>$event,'group'=>$group]));
});

// Home / [group] / Events / [event->title] / Delete
Breadcrumbs::for('groups.events.delete', function ($trail, $group, $event) {
  $trail->parent('groups.events.view', $group, $event);
  $trail->push('Delete', route('groups.events.delete', ['event'=>$event,'group'=>$group]));
});

// Home / [group->title] / Members
Breadcrumbs::for('groups.members', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Members', route('groups.members', ['group'=>$group]));
});

// Home / [group->title] / Leave Group
Breadcrumbs::for('groups.leave', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Leave Group', route('groups.leave', ['group'=>$group]));
});

/* Group Invitations */

// My Group Invitations
Breadcrumbs::for('invitations', function ($trail) {
  $trail->parent('home');
  $trail->push('My Group invitations', route('invitations'));
});

Breadcrumbs::for('groups.invite', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Invite To Group', route('groups.invite', ['group'=>$group]));
});

Breadcrumbs::for('groups.invites.join', function ($trail, $group) {
  $trail->parent('home');
  $trail->push('Join Group', route('groups.invites.join', ['group'=>$group]));
});

Breadcrumbs::for('groups.invites.decline', function ($trail, $group) {
  $trail->parent('home');
  $trail->push('Decline Invitation', route('groups.invites.decline', ['group'=>$group]));
});

/* Events */
// Home / My Events
Breadcrumbs::for('events.index', function ($trail) {
  $trail->parent('home');
  $trail->push('My Events', route('events.index'));
});

// Events / New can optionally have a [group] prefix, if the group is set on the request
// Home / My Events / New
// Home / [group] / Events / New
Breadcrumbs::for('events.new', function ($trail, $group=null) {
  if($group){
    $trail->parent('groups.events.index', $group);
    $trail->push('New', route('groups.events.new', $group));
  }else{
    $trail->parent('events.index');
    $trail->push('New', route('events.new'));
  }
});