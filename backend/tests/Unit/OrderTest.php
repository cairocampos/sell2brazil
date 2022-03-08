<?php

namespace Tests\Unit;

use App\Dto\OrderItemDTO;
use App\Order;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function should_be_able_get_order_items()
    {
        $order = new OrderRepository();
        $order->addItem(new OrderItemDTO('ABC', 'StringName', 25.50, 2));
        $order->addItem(new OrderItemDTO('TEST', 'Product', 25.50, 2));

        $this->assertIsArray($order->getItems());
    }

    /** @test */
    public function test_sum_total_order()
    {
        $order = new OrderRepository();
        $order->addItem(new OrderItemDTO('ABC', 'StringName', 50, 2));
        $order->addItem(new OrderItemDTO('TEST', 'Product', 50, 2));

        $this->assertEquals(100, $order->sumTotalOrder());
    }

    public function amountProvider() {
        return [
            [500,5],
            [501,5],
            [499,5],
            [700,5],
        ];
    }

    /**
     * @test
     * @dataProvider amountProvider
     */
    public function test_sum_total_order_discount($amount, $quantity)
    {
        $order = new OrderRepository();
        $order->addItem(new OrderItemDTO('ABC', 'StringName', $amount, $quantity));

        $totalOder = $order->sumTotalOrder();
        $totalDiscount = $totalOder >= Order::TOTAL_ORDER_MIN_WITH_DISCOUNT ?
            $totalOder - ((Order::PERCENT_MAX_DISCOUNT / 100)*$totalOder) : $totalOder;

        $this->assertEquals($totalDiscount, $order->sumTotalOrderWithDiscount());
    }
}
