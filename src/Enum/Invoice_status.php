<?php

namespace App\Enum;
enum Invoice_status: string
{
    case PAID = 'PAID';
    case UNPAID = 'UNPAID';
    case PENDING = 'PENDING';
    case CANCELLED = 'CANCELLED';
}