<?php

namespace Tests\Feature;

use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_order()
    {
        $response = $this->post('/api/orders', [
            [
                'ArticleCode' => $this->faker->uuid(),
                'ArticleName' => $this->faker->name(),
                'UnitPrice'   => 25,
                'Quantity'    => 2,
            ]
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('orders', 1);
    }

    /** @test */
    public function test_sum_total_order()
    {
        $response = $this->post('/api/orders', [
            [
                'ArticleCode' => $this->faker->uuid(),
                'ArticleName' => $this->faker->name(),
                'UnitPrice'   => 25,
                'Quantity'    => 2,
            ],
            [
                'ArticleCode' => $this->faker->uuid(),
                'ArticleName' => $this->faker->name(),
                'UnitPrice'   => 50,
                'Quantity'    => 2,
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'TotalAmountWihtoutDiscount' => 75,
            'TotalAmountWithDiscount'    => 75
        ]);
    }

    public function aggregateProvider()
    {
        return [
            [[
                [
                    'ArticleCode' => 'sameCode',
                    'ArticleName' => 'name',
                    'UnitPrice'   => 255,
                    'Quantity'    => 2,
                ],
                [
                    'ArticleCode' => 'sameCode',
                    'ArticleName' => 'name',
                    'UnitPrice'   => 255,
                    'Quantity'    => 3,
                ]
            ]],
            [[
                [
                    'ArticleCode' => 'test',
                    'ArticleName' => 'name',
                    'UnitPrice'   => 354,
                    'Quantity'    => 2,
                ],
                [
                    'ArticleCode' => 'test',
                    'ArticleName' => 'name',
                    'UnitPrice'   => 354,
                    'Quantity'    => 3,
                ]
            ]]
        ];
    }


    /**
     * @test
     * @dataProvider aggregateProvider
     */
    public function test_sum_total_order_discount_with_aggregate_article($article)
    {
        $response = $this->post('/api/orders', $article);

        $totalOrder = 554 + 50;
        $totalDiscount = $totalOrder - ((Order::PERCENT_MAX_DISCOUNT / 100) * $totalOrder);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function should_be_not_able_create_an_order_with_same_product_with_different_price()
    {
        $price1 = 354.25;
        $price2 = 300;
        $response = $this->post('/api/orders', [
            [
                'ArticleCode' => 'test',
                'ArticleName' => 'name',
                'UnitPrice'   => $price1,
                'Quantity'    => 2,
            ],
            [
                'ArticleCode' => 'test',
                'ArticleName' => 'name',
                'UnitPrice'   => $price2,
                'Quantity'    => 3,
            ]
        ]);

        $response->assertStatus(400);
        $this->assertDatabaseCount('orders', 0);
    }
}
