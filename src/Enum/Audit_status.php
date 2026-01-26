<?php
namespace App\Enum;

enum Audit_status: string
{
    case PENDING = 'PENDING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMLETED';
    case CANCELLED = 'CANCELLED';

}