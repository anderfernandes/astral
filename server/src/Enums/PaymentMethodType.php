<?php

namespace App\Enums;

enum PaymentMethodType: string
{
    case Cash = 'cash';
    case Card = 'card';
    case Check = 'check';
    case Online = 'online';
    case Other = 'other';
}
