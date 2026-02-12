<?php

namespace App\Notifications;

use App\Models\OrdenTrabajo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TecnicoAsignadoNotification extends Notification implements ShouldQueue
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
        $tecnico = $this->orden->tecnico->user;
        $fecha = $this->orden->fecha_asignada?->format('d/m/Y H:i');

        return (new MailMessage)
            ->subject('Técnico asignado - HANDY SOLUTIONS')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Se ha asignado un técnico a tu solicitud.')
            ->line('**Orden:** ' . $this->orden->codigo)
            ->line('**Técnico:** ' . $tecnico->name)
            ->line('**Fecha prevista:** ' . ($fecha ?? 'Por confirmar'))
            ->action('Ver detalle', url('/solicitudes/' . $this->orden->solicitud_id))
            ->line('Gracias por confiar en nosotros.');
    }
}
