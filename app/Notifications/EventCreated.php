<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventCreated extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($creator,$event,$group)
  {
    $this->creator = $creator;
    $this->event = $event;
    $this->group = $group;
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
      'text' => "<strong>".e($this->creator->name)."</strong> created an event in <strong>".e($this->group->name)."</strong>",
      'url' => route('events.view', ['event'=>$this->event->id]),
      'creator_id' => $this->creator->id,
      'icon' => 'calendar-plus'
    ];
  }
}
