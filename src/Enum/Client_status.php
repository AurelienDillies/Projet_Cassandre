<?php
namespace App\Enum;
enum Client_status: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case SUSPENDED = 'SUSPENDED';
    case DELETED = 'DELETED';
}