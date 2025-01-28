<?php

namespace App\Enums;

enum PaymentMethodType: string
{
    case CASH = 'cash';
    case CARD = 'card';
    case CHECK = 'check';
    case ONLINE = 'online';
    case OTHER = 'other';
}
