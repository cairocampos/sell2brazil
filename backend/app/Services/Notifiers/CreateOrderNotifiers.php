<?php

namespace App\Services\Notifiers;

use App\Jobs\SyncServer;
use App\Order;

class CreateOrderNotifiers
{
  private $order;
  protected $notifiers = [
    ApiNotifier::class,
    WebApiNotifier::class
  ];

  public function __construct(Order $order)
  {
    $this->order = $order;
  }
  
  public function handle()
  {
    foreach($this->notifiers as $notifier) {
      SyncServer::dispatch($this->order, $notifier);
    }
  }
}