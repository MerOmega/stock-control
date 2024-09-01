<?php

namespace App;

enum State: string
{
    case InUse = 'en_uso';
    case InRepair = 'en_reparacion';
    case WaitingForParts = 'esperando_repuesto';
    case OnHold = 'en_espera';

    public function label(): string
    {
        return match($this) {
            self::InUse => 'En uso',
            self::InRepair => 'En reparación',
            self::WaitingForParts => 'Esperando repuesto',
            self::OnHold => 'En espera',
        };
    }
}
