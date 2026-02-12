<?php

namespace App\Notifications;

use App\Models\OrdenTrabajo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServicioCompletadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public OrdenTrabajo $orden
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Servicio completado - HANDY SOLUTIONS')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Tu servicio ha sido completado.')
            ->line('**Orden:** ' . $this->orden->codigo)
            ->action('Dejar reseña', url('/solicitudes/' . $this->orden->solicitud_id))
            ->line('Gracias por elegir HANDY SOLUTIONS.');
    }
}
