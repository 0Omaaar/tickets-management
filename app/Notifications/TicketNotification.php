<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $type;
    protected $user;

    public function __construct(Ticket $ticket, string $type, $user = null)
    {
        $this->ticket = $ticket;
        $this->type = $type;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = '';
        $message = '';

        switch ($this->type) {
            case 'created':
                $subject = 'Nouveau ticket créé';
                $message = "Un nouveau ticket a été créé : {$this->ticket->title}";
                break;
            case 'status_updated':
                $subject = 'Mise à jour du statut du ticket';
                $message = "Le statut du ticket {$this->ticket->title} a été mis à jour vers : {$this->ticket->status}";
                break;
            case 'assigned':
                $subject = 'Ticket assigné';
                $message = "Le ticket {$this->ticket->title} vous a été assigné";
                break;
        }

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line($message)
            ->line('Projet : ' . $this->ticket->module->project->name)
            ->line('Module : ' . $this->ticket->module->name)
            ->line('Priorité : ' . $this->ticket->priority)
            ->line('Type : ' . $this->ticket->type)
            ->action('Voir le ticket', url('https://ticketis.online'))
            ->line('Merci d\'utiliser notre application !');
    }
}
