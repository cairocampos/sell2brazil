<?php

namespace App\Dto;

class OrderItemDTO
{
  public string $ArticleCode;
  public string $ArticleName;
  public float $UnitPrice;
  public int $Quantity;

  public function __construct(
    string $ArticleCode,
    string $ArticleName,
    float $UnitPrice,
    int $Quantity
  )
  {
    $this->ArticleCode = $ArticleCode;
    $this->ArticleName = $ArticleName;
    $this->UnitPrice = $UnitPrice;
    $this->Quantity = $Quantity;
  }
}