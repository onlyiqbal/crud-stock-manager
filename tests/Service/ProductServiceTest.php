<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\ProductAddRequest;
use Iqbal\StockManager\Model\ProductUpdateRequest;
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

     public function testShowAllProductSuccess()
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

     public function testAddSuccess()
     {
          $request = new ProductAddRequest();
          $request->name = "Laptop";
          $request->quantity = 5;
          $request->price = 500000;
          $response = $this->productService->add($request);

          $this->assertEquals($request->name, $response->products->name);
          $this->assertEquals($request->price, $response->products->price);
          $this->assertEquals($request->quantity, $response->products->quantity);
     }

     public function testAddFailed()
     {
          $this->expectException(ValidationException::class);

          $request = new ProductAddRequest();
          $request->name = "";
          $request->quantity = null;
          $request->price = null;

          $this->productService->add($request);
     }

     public function testUpdateSuccess()
     {
          $product = new Product();
          $product->name = "celana";
          $product->quantity = 10;
          $product->price = 50000;
          $this->productRepository->save($product);

          $request = new ProductUpdateRequest();
          $request->id = 1;
          $request->name = "hp";
          $request->quantity = 5;
          $request->price = 500000;
          $this->productService->updateProduct($request);

          $result = $this->productRepository->findById(1);

          $this->assertEquals($request->id, $result->id);
          $this->assertEquals($request->name, $result->name);
          $this->assertEquals($request->quantity, $result->quantity);
          $this->assertEquals($request->price, $result->price);
     }

     public function testUpdateFailed()
     {
          $product = new Product();
          $product->name = "celana";
          $product->quantity = 10;
          $product->price = 50000;
          $this->productRepository->save($product);

          $this->expectException(ValidationException::class);

          $request = new ProductUpdateRequest();
          $request->id = 1;
          $request->name = "";
          $request->quantity = "";
          $request->price = "";
          $this->productService->updateProduct($request);
     }

     public function testDeleteByIdSuccess()
     {
          $product = new Product();
          $product->name = "Gosokan";
          $product->quantity = 20;
          $product->price = 500000;
          $this->productRepository->save($product);

          $product = $this->productRepository->showAll();
          $result = $product->fetch();

          $this->productService->deleteProduct($result['id']);
          $result_product = $this->productRepository->findById($result['id']);

          $this->assertNull($result_product);
     }
}
