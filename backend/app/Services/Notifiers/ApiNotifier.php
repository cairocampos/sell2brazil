<?php

namespace App\Services\Notifiers;

use App\Order;
use Illuminate\Support\Facades\Http;

class ApiNotifier implements INotifier
{
  public function handle(Order $order)
  {
    $base_url = config('webservices.server01');
    Http::post("{$base_url}/orders", [
      'id' => $order->OrderId,
      'code' => $order->OrderCode,
      'date' => $order->OrderDate,
      'total' => $order->TotalAmountWihtoutDiscount,
      'discount' => $order->TotalAmountWithDiscount
    ]);
  }
}