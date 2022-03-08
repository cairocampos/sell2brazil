<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'OrderId';
    protected $guarded = [];

    const TOTAL_ORDER_MIN_WITH_DISCOUNT = 500;
    const PERCENT_MAX_DISCOUNT = 15;
}
