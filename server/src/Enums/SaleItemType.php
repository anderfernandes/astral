<?php

namespace App\Enums;

enum SaleItemType: string
{
    case Ticket = 'Ticket';
    case Product = 'Product';
    case Membership = 'Membership';
}
