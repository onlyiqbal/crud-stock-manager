<?php

namespace Iqbal\StockManager\Domain;

class Product
{
     public ?int $id;
     public string $name;
     public int $quantity;
     public string $price;
     public ?string $update_at;
}
