<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

/** In-system (database) notification. Add 'mail' to via() once SMTP is configured. */
class TicketNotification extends Notification
{
    public function __construct(
        public int $ticketId,
        public string $ticketNo,
        public string $message,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'ticket_id' => $this->ticketId,
            'ticket_no' => $this->ticketNo,
            'message' => $this->message,
        ];
    }
}
