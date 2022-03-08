<?php

namespace App\Services\Notifiers;

use App\Order;

interface INotifier
{
  public function handle(Order $order);
}