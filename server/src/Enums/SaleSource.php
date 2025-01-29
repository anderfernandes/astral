<?php

namespace App\Enums;

enum SaleSource: string
{
    case CASHIER = 'cashier';
    case ADMIN = 'admin';
    case INTERNAL = 'internal';
    case EXTERNAL = 'external';
}
