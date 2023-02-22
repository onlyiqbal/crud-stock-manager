<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Model\ProductAddRequest;
use Iqbal\StockManager\Model\ProductUpdateRequest;
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
          $request = new ProductAddRequest();
          $request->name = "Hp";
          $request->quantity = 5;
          $request->price = 5000000;

          $product = new Product();
          $product->name = $request->name;
          $product->quantity = $request->quantity;
          $product->price = $request->price;

          $result = $this->productRepository->save($product);

          $this->assertNotNull($result);
     }

     public function testShowAll()
     {
          $result = $this->productRepository->showAll();

          $this->assertNotNull($result);
     }

     public function testUpdateSuccess()
     {
          $product = new Product();
          $product->name = "celana";
          $product->quantity = 10;
          $product->price = 50000;
          $this->productRepository->save($product);

          $product->id = 1;
          $product->name = "hp";
          $product->quantity = 5;
          $product->price = 150000;
          $this->productRepository->update($product);

          $product_result = $this->productRepository->findById(1);

          $this->assertEquals($product_result->id, $product->id);
          $this->assertEquals($product_result->name, $product->name);
          $this->assertEquals($product_result->quantity, $product->quantity);
          $this->assertEquals($product_result->price, $product->price);
     }

     public function testDeleteByIdSuccess()
     {
          $product = new Product();
          $product->name = "Mesin Cuci";
          $product->quantity = 10;
          $product->price = 5000000;
          $this->productRepository->save($product);

          $product = $this->productRepository->showAll();
          $result = $product->fetch();
          $this->productRepository->deleteById($result['id']);

          $result_product = $this->productRepository->findById($result['id']);

          $this->assertNull($result_product);
     }
}
