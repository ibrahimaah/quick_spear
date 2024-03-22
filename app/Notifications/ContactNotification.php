<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    use Queueable;
    private $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->line($this->data['body'])
    //         ->action($this->data['offerText'], $this->data['offerUrl'])
    //         ->line($this->data['thanks']);
    // }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->data['user_id'],
            'body' => $this->data['body'],
            'link' => $this->data['link'],
        ];
    }
}
