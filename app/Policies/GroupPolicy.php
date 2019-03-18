<?php

namespace App\Policies;

use App\User;
use App\Group;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

/*
  GroupPolicy - the policy authorization file for Group related routes.
  The following routes are available to all users and doesn't require a check:
    - groups.join
    - groups.decline
    - groups.acceptInvite
    - groups.declineInvite
    - groups.index
*/
class GroupPolicy
{
  use HandlesAuthorization;

  /*
    isInGroup($user,$group) - Check if the user is in the group.
  */
  private function isInGroup(User $user, Group $group){
    $group->loadMissing('users');
    $group_user = $group->users->firstWhere('id',$user->id);
    return ($group_user ? true :  false);
  }

  /*
    isGroupAdmin($user,$group) - Check if the user is in the group and is an admin.
  */
  private function isGroupAdmin(User $user, Group $group){
    $group->loadMissing('users');
    $group_user = $group->users->firstWhere('id',$user->id);
    return ($group_user && $group_user->pivot->role === "admin");
  }

  /*
    isCommentCreator($user,$comment) - Check if the user is creator of the comment.
  */
  private function isCommentCreator(User $user, Comment $comment){
    return $comment->user_id === $user->id;
  }

  /*
    isEventCreator($user,$event) - Check if the user is creator of the event.
  */
  private function isEventCreator(User $user, Event $event){
    return $event->user_id === $user->id;
  }

  /*
    View Group: only members can view the group
    Used for the following routes:
      - groups.view
      - groups.members
      - groups.events
      - groups.events.new
      - ajax.groups.createComment
  */
  public function view(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  public function members(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  public function events(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  public function newEvent(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  public function viewEvent(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  public function createComment(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }

  /* 
    Leave Group: only non-demo, group members can leave the group.
    Used for:
      - groups.leave
      - groups.leaveGroup
  */

  public function leave(User $user, Group $group){
    return $this->isInGroup($user,$group) && !$user->demo;
  }

  public function leaveGroup(User $user, Group $group){
    return $this->isInGroup($user,$group) && !$user->demo;
  }

  /*
    Create Group: only non-demo users can create a new group
    Used for:
      - groups.new
      - groups.create
  */
  public function new(User $user){
    return !$user->demo;
  }

  public function create(User $user){
    return !$user->demo;
  }

  /*
    Update Group: only non-demo, group admins can update the group
    Used for:
      - groups.edit
      - groups.update
      - groups.invite
      - groups.createInvite
      - ajax.groups.updateMember
      - ajax.groups.deleteMember
  */
  public function edit(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }

  public function update(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }
  
  public function invite(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }
  
  public function createInvite(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }

  public function updateMember(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }

  public function deleteMember(User $user, Group $group){
    return ($this->isGroupAdmin($user,$group) && !$user->demo);
  }

  /*
    Comment Group: these policies are valid if the user is either the comment's creator or a group admin.
    Used for:
      - ajax.groups.updateComment
      - ajax.groups.destroyComment
  */
  public function updateComment(User $user, Group $group, Comment $comment){
    return $this->isCommentCreator($user, $comment) || $this->isGroupAdmin($user,$group);
  }

  public function destroyComment(User $user, Group $group, Comment $comment){
    return $this->isCommentCreator($user, $comment) || $this->isGroupAdmin($user,$group);
  }

  
  /*
    Misc Policies
  */
  
  /*
    manageComments($user,$group) - If the user is a group admin they can update/deleteComments.
  */
  public function manageComments(User $user, Group $group){
    return $this->isGroupAdmin($user,$group);
  }

  /*
    manageEvents($user,$group) - If the user is a group admin, they can manage the group's events.
  */
  public function manageEvents(User $user, Group $group){
    return $this->isGroupAdmin($user,$group);
  }

  /*
    attendEvents($user,$group) - If the user is a group member they can attend a group event.
  */
  public function attendEvents(User $user, Group $group){
    return $this->isInGroup($user,$group);
  }
}
