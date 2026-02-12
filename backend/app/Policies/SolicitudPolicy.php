<?php

namespace App\Policies;

use App\Models\Solicitud;
use App\Models\User;

class SolicitudPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Solicitud $solicitud): bool
    {
        return $user->id === $solicitud->user_id || $user->isAdmin() || $user->isTecnico();
    }
}
