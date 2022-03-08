<?php

namespace App\Repositories;

use App\Dto\OrderItemDTO;
use App\Order;
use App\Repositories\Interfaces\IOrderRepository;

class OrderRepository implements IOrderRepository
{
    private $orderItems = [];

    public function __construct()
    {
        $this->orderItems = [];
    }

    public function addItem(OrderItemDTO $item)
    {
        $this->orderItems[] = $item;
    }

    public function getItems()
    {
        return $this->orderItems;
    }

    public function sumTotalOrder()
    {
        if(empty($this->getItems())) return 0;

        return collect($this->getItems())->reduce(function ($prev, $accumulator) {
            if(empty($prev)) return $accumulator->UnitPrice;

            return $prev += $accumulator->UnitPrice;
        });
    }

    public function sumTotalOrderWithDiscount()
    {
        $totalOrder = $this->sumTotalOrder();
        foreach($this->getItems() as $item) {
            if($totalOrder >= Order::TOTAL_ORDER_MIN_WITH_DISCOUNT
                && ($item->Quantity >= 5 && $item->Quantity <= 9)) {
                return $totalOrder - ((Order::PERCENT_MAX_DISCOUNT / 100) * $totalOrder);
            }
        }

        return $totalOrder;
    }

    public function save()
    {
        $order = Order::create([
            'TotalAmountWihtoutDiscount' => $this->sumTotalOrder(),
            'TotalAmountWithDiscount'    => $this->sumTotalOrderWithDiscount()
        ]);
        return $order;
    }
}
