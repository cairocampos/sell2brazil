<?php

namespace App\Services;

use App\Dto\OrderItemDTO;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrderService
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(array $articles)
    {
        foreach(collect($articles)->groupBy('ArticleCode')->toArray() as $grouped) {
            $item = collect($grouped)->reduce(function ($prev, $accumulator) {
                if(empty($prev)) return $accumulator;
                if($accumulator['UnitPrice'] !== $prev['UnitPrice']) {
                    throw new HttpException(
                        Response::HTTP_BAD_REQUEST,
                        'Produtos com o mesmo código não pode ter valores diferentes.'
                    );
                }

                $accumulator['Quantity'] += $prev['Quantity'];

                return $accumulator;
            });
            $this->orderRepository->addItem(
                new OrderItemDTO(
                    $item['ArticleCode'],
                    $item['ArticleName'],
                    $item['UnitPrice'],
                    $item['Quantity']
                )
            );
        }
        $order = $this->orderRepository->save();

        return $order;
    }
}
