<?php

namespace Iqbal\StockManager\Model;

class ProductUpdateRequest
{
    public ?int $id;
    public string $name;
    public string $quantity;
    public string $price;
}
