<?php

namespace Iqbal\StockManager\Service;

use Exception;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\ProductAddRequest;
use Iqbal\StockManager\Model\ProductAddResponse;
use Iqbal\StockManager\Model\ProductUpdateRequest;
use Iqbal\StockManager\Model\ProductUpdateResponse;
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

     public function add(ProductAddRequest $request): ProductAddResponse
     {
          $this->validateProductAddRequest($request);

          try {
               Database::beginTransaction();
               $product = new Product();
               $product->name = $request->name;
               $product->quantity = $request->quantity;
               $product->price = $request->price;
               $this->productRepository->save($product);

               $response = new ProductAddResponse();
               $response->products = $product;
               Database::commitTransaction();

               return $response;
          } catch (Exception $exception) {
               Database::rollBackTransaction();
               throw $exception;
          }
     }

     private function validateProductAddRequest(ProductAddRequest $request)
     {
          if (($request->name == "" || null) || ($request->quantity == "" || null) || ($request->price == "" || null)) {
               throw new ValidationException("Form tidak boleh kosong");
          }
     }

     public function updateProduct(ProductUpdateRequest $request): ProductUpdateResponse
     {
          $this->validateProductUpdate($request);

          try {
               Database::beginTransaction();

               $product = $this->productRepository->findById($request->id);
               if ($product == null) {
                    throw new ValidationException("Produk tidak ada");
               }

               $product->id = $request->id;
               $product->name = $request->name;
               $product->quantity = $request->quantity;
               $product->price = $request->price;
               $this->productRepository->update($product);

               Database::commitTransaction();

               $response = new ProductUpdateResponse();
               $response->product = $product;

               return $response;
          } catch (Exception $exception) {
               Database::rollBackTransaction();
               throw $exception;
          }
     }

     private function validateProductUpdate(ProductUpdateRequest $request)
     {
          if (($request->name == null || "") || ($request->quantity == null || "") || ($request->price == null || "")) {
               throw new ValidationException("Form harus diisi");
          }
     }

     public function deleteProduct(string $id)
     {
          $this->productRepository->deleteById($id);
     }
}
