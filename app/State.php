<?php

namespace App;

enum State: string
{
    case InUse = 'en_uso';
    case InRepair = 'en_reparacion';
    case WaitingForParts = 'esperando_repuesto';
    case OnHold = 'en_espera';
}
