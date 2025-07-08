<?php

namespace App\Enums;

enum MemberPosition: string
{
    case PRIMARY = 'Primary';
    case FREE_SECONDARY = 'Free Secondary';
    case PAID_SECONDARY = 'Paid Secondary';
}
