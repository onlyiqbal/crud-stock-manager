<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Repository\ProductRepository;
use PDOStatement;

class ProductService
{
     private ProductRepository $productRepository;

     public function __construct(ProductRepository $productRepository)
     {
          $this->productRepository = $productRepository;
     }

     public function showAllProducts(): ?PDOStatement
     {
          $products = $this->productRepository->showAll();
          return $products;
     }
}
