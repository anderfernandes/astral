<?php

namespace App\Enums;

enum SaleStatus: string
{
    case Open = "open";
    case Tentative = "tentative";
    case Completed = "completed";
    case Canceled = "canceled";
}