<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
     private ProductRepository $productRepository;

     protected function setUp(): void
     {
          $this->productRepository = new ProductRepository(Database::getConnection());
          $this->productRepository->deleteAll();
     }
     public function testSaveSuccess()
     {
          $product = new Product();
          $product->id = "1";
          $product->name = "HP";
          $product->quantity = "5";
          $product->price = "1500000000";
          $product->update_at = "2022-06-27";
          $this->productRepository->save($product);

          $result = $this->productRepository->findById($product->id);

          $this->assertEquals($result->id, $product->id);
     }

     public function testShowAll()
     {
          $result = $this->productRepository->showAll();

          $this->assertNotNull($result);
     }
}
