<?php

namespace App\Services\Notifiers;

use App\Order;
use Illuminate\Support\Facades\Http;

class WebApiNotifier implements INotifier
{
  public function handle(Order $order)
  {
    $base_url = config('webservices.server02');
    Http::post("{$base_url}/orders", [
      'id' => $order->OrderId,
      'code' => $order->OrderCode,
      'date' => $order->OrderDate,
      'totalAmount' => $order->TotalAmountWihtoutDiscount,
      'totalAmountWithDiscount' => $order->TotalAmountWithDiscount,
    ]);
  }
}