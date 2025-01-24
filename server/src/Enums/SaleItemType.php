<?php

namespace App\Enums;

enum SaleItemType: string
{
    case Ticket = "ticket";
    case Product = "product";
    case Membership = "membership";
}