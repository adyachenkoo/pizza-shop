<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case CLOSED = 1;
    case DELIVERING = 2;
    case PREPARING = 3;
}
