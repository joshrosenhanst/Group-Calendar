<?php
// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', route('home'));
});

/* GROUPS */
// Home / Groups
Breadcrumbs::for('groups.index', function ($trail) {
  $trail->parent('home');
  $trail->push('Groups', route('groups.index'));
});
// Home / Groups / New
Breadcrumbs::for('groups.new', function ($trail, $group) {
  $trail->parent('groups.index');
  $trail->push('New', route('groups.new'));
});
// Home / Groups / [group->title]
Breadcrumbs::for('groups.view', function ($trail, $group) {
  $trail->parent('groups.index');
  $trail->push($group->name, route('groups.view', ['group'=>$group]));
});
// Home / Groups / [group->title] / Events
Breadcrumbs::for('groups.events', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Events', route('groups.events', ['group'=>$group]));
});
// Home / Groups / [group->title] / Events / New
Breadcrumbs::for('groups.events.new', function ($trail, $group) {
  $trail->parent('groups.events', $group);
  $trail->push('New', route('groups.events.new', ['group'=>$group]));
});
// Home / Groups / [group->title] / Members
Breadcrumbs::for('groups.members', function ($trail, $group) {
  $trail->parent('groups.view', $group);
  $trail->push('Members', route('groups.members', ['group'=>$group]));
});

/* Events */
// Events can optionally have a [group] prefix, if the group is set on the request
// Home / Events (no group)
// Home / Groups / [group] / Events
Breadcrumbs::for('events.index', function ($trail) {
  $trail->parent('home');
  $trail->push('Events', route('events.index'));
});
// Home / Events / New (no group)
// Home / Groups / [group] / Events / New
Breadcrumbs::for('events.new', function ($trail) {
  $trail->parent('events.index');
  $trail->push('New', route('events.new'));
});
Breadcrumbs::for('events.view', function ($trail, $event) {
  $trail->parent('events.index');
  $trail->push($event->name, route('events.view', ['event'=>$event]));
});