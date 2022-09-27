<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DonateStatus extends Enum
{
    const Start = 0;
    const Pay = 1;
    const Cancel = 2;
}
