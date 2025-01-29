<?php

namespace App\Enums;

enum SaleStatus: string
{
    case OPEN = 'open';
    case TENTATIVE = 'tentative';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
