<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class GroupCommentCreated extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($creator,$group,$text)
  {
    $this->creator = $creator;
    $this->group = $group;
    $this->text = Str::limit($text, 100, "...");
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
      'text' => "<strong>".e($this->creator->name)."</strong> commented on  <strong>".e($this->group->name)."</strong>:<br><span class='notification_comment'>\"".e($this->text)."\"</span>",
      'creator_id' => $this->creator->id,
      'url' => route('groups.view', ['group'=>$this->group->id]),
      'icon' => 'comment-plus'
    ];
  }
}
