<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
     private ProductService $productService;
     private ProductRepository $productRepository;

     protected function setUp(): void
     {
          $this->productRepository = new ProductRepository(Database::getConnection());
          $this->productService = new ProductService($this->productRepository);
          $this->productRepository->deleteAll();
     }

     public function testshowAllProductSuccess()
     {
          $product = new Product();
          $product->id = "1";
          $product->name = "Laptop";
          $product->quantity = "5";
          $product->price = "5000000";
          $product->update_at = "2022-06-29";
          $this->productRepository->save($product);

          $result = $this->productService->showAllProducts();

          $this->assertNotNull($result);
     }
}
