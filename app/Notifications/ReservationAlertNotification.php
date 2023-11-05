<?php

namespace App\Notifications;

use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;
    protected $client;

    public function __construct(Reservation $reservation, Client $client)
    {
        $this->reservation = $reservation;
        $this->client = $client;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Reminder: Your reservation is coming up Mr : ' .  $this->client->name . '!')
            ->line('Reservation details:')
            ->line('Date: ' . $this->reservation->date)
            ->line('Start Time: ' . $this->reservation->start_time)
            ->line('End Time: ' . $this->reservation->end_time)
            ->line('Thank you for choosing our services!');
    }
}
