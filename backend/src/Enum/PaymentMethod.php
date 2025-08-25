<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CARD = 'card';
    case MOBILE_MONEY = 'mobile_money';
    case TRANSFER = 'transfer';
}
