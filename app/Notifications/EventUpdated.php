<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventUpdated extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($creator,$event)
  {
    $this->creator = $creator;
    $this->event = $event;
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
      'text' => "<strong>".e($this->event->name)."</strong> was updated by <strong>".e($this->creator->name)."</strong>",
      'url' => route('events.view', ['event'=>$this->event->id]),
      'creator_id' => $this->creator->id,
      'icon' => 'calendar-edit'
    ];
  }
}
