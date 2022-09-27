<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Student = 'student';
    const Parent = 'parent';
    const Alumni = 'alumni';
}
