<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvited extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($user, $group, $creator)
  {
    $this->user = $user;
    $this->group = $group;
    $this->creator = $creator;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['database'];
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      'text' => 'You have been invited to join <strong>'.e($this->group->name).'</strong> by <strong>'.e($this->creator->name).'</strong>',
      'url' => route('groups.invites.join', ['group'=>$this->group]),
      'creator_id' => $this->creator->id,
      'icon' => 'account-plus'
    ];
  }
}
