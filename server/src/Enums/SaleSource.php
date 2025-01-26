<?php

namespace App\Enums;

enum SaleSource: string
{
    case Cashier = 'cashier';
    case Admin = 'admin';
    case Internal = 'internal';
    case External = 'external';
}
