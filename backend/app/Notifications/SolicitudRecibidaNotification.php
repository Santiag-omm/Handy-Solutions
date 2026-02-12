<?php

namespace App\Notifications;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudRecibidaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Solicitud $solicitud
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $cotizacion = $this->solicitud->cotizacionActual;
        $monto = $cotizacion ? number_format($cotizacion->monto, 2) : 'N/A';

        return (new MailMessage)
            ->subject('Solicitud recibida - HANDY SOLUTIONS')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Hemos recibido tu solicitud de servicio.')
            ->line('**Folio:** ' . $this->solicitud->folio)
            ->line('**Servicio:** ' . $this->solicitud->servicio->nombre)
            ->line('**Cotización estimada:** $' . $monto)
            ->action('Ver detalle', url('/solicitudes/' . $this->solicitud->id))
            ->line('Un asesor validará tu solicitud y te asignaremos un técnico.');
    }
}
