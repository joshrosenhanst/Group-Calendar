<?php

namespace App\Policies;

use App\User;
use App\Event;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
  use HandlesAuthorization;

  /*
    isEventCreator($user,$event) - Check if the user is creator of the event.
  */
  private function isEventCreator(User $user, Event $event){
    return $event->creator_id === $user->id;
  }
  /*
    isCommentCreator($user,$comment) - Check if the user is creator of the comment.
  */
  private function isCommentCreator(User $user, Comment $comment){
    return $comment->user_id === $user->id;
  }

  /*
    Create Event: users can only create a new event if they belong to a group.
    Used for:
      - events.new
      - events.create
  */
  public function new(User $user){
    return ($user->groups->count() ? true : false);
  }

  public function create(User $user){
    return ($user->groups->count() ? true : false);
  }

  /* 
    Update Event: users can only edit an event if they created the event or they are an admin in the group.
    Used for:
      - groups.events.edit
      - groups.events.delete
      - events.update
      - events.destroy
  */
  public function edit(User $user, Event $event){
    $event->loadMissing('group');
    return $this->isEventCreator($user,$event) || ($event->group && $user->can('manageEvents', $event->group));
  }

  public function delete(User $user, Event $event){
    $event->loadMissing('group');
    return $this->isEventCreator($user,$event) || ($event->group && $user->can('manageEvents', $event->group));
  }

  public function update(User $user, Event $event){
    $event->loadMissing('group');
    return $this->isEventCreator($user,$event) || ($event->group && $user->can('manageEvents', $event->group));
  }

  public function destroy(User $user, Event $event){
    $event->loadMissing('group');
    return $this->isEventCreator($user,$event) || ($event->group && $user->can('manageEvents', $event->group));
  }

  /*
    attend($user,$event) - Users can only attend the event if they are a member of the group.
  */
  public function attend(User $user, Event $event){
    $event->loadMissing('group');
    return ($event->group && $user->can('attendEvents', $event->group));
  }

  /*
    createComment($user,$event) - Users can only comment on events if they are in the event's group.
  */
  public function createComment(User $user, Event $event){
    $event->loadMissing('group');
    return $event->group && $user->can('createComment', $event->group);
  }

  /*
    Manage Comment Group: Users can only edit/delete comments that they created or they are group admins.
  */
  public function updateComment(User $user, Event $event, Comment $comment){
    $event->loadMissing('group');
    return $this->isCommentCreator($user,$event) || ($event->group && $user->can('manageComments', $event->group));
  }
  
  public function destroyComment(User $user, Event $event, Comment $comment){
    $event->loadMissing('group');
    return $this->isCommentCreator($user,$event) || ($event->group && $user->can('manageComments', $event->group));
  }
}
