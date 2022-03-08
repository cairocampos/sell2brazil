<?php

namespace App\Repositories\Interfaces;

use App\Dto\OrderItemDTO;

interface IOrderRepository
{
  public function addItem(OrderItemDTO $item);
  public function getItems();
  public function sumTotalOrder();
  public function sumTotalOrderWithDiscount();
  public function save();
}