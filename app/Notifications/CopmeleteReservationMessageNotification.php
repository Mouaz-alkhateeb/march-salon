<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CopmeleteReservationMessageNotification extends Notification
{
    use Queueable;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->line('Message confirming your Reservation.')
            ->line('Your reservation has been confirmed, Mr. ' . $this->client->name)
            ->line('Thank you for using March Salon.');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
