<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EventsVisitStatus extends Enum
{
    const NEW = 0;
    const CONFIRMED = 1;
    const UNCONFIRMED = 2;
}
