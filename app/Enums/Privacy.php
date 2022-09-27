<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Privacy extends Enum
{
    const Off = 0;
    const All = 1;
    const Student = 2;
    const Parent = 3;
}
