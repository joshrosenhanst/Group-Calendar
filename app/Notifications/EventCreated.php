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
  public function __construct($creator,$event_id,$group_name)
  {
    $this->creator = $creator;
    $this->event_id = $event_id;
    $this->group_name = $group_name;
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
      'text' => "<strong>".e($this->creator->name)."</strong> created an event in <strong>".e($this->group_name)."</strong>",
      'url' => route('events.view', ['event'=>$this->event_id]),
      'creator_id' => $this->creator->id,
      'icon' => 'calendar-plus'
    ];
  }
}
