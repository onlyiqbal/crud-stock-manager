<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\ProductAddRequest;
use Iqbal\StockManager\Model\ProductUpdateRequest;
use Iqbal\StockManager\Repository\ProductRepository;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\ProductService;
use Iqbal\StockManager\Service\SessionService;

class ProductController
{
     private ProductService $productService;
     private ProductRepository $productRepository;
     private SessionService $sessionService;

     public function __construct()
     {
          $this->productRepository = new ProductRepository(Database::getConnection());
          $this->productService = new ProductService($this->productRepository);
          $sessionRepository = new SessionRepository(Database::getConnection());
          $userRepository = new UserRepository(Database::getConnection());
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }

     public function add()
     {
          $session = $this->sessionService->current();
          View::renderProduct("Barang/add", [
               "title" => "Tambah Barang",
               "name" => $session->userId
          ]);
     }

     public function postAdd()
     {
          $request = new ProductAddRequest();
          $request->name = $_POST['name'];
          $request->quantity = $_POST['quantity'];
          $request->price = $_POST['price'];

          $session = $this->sessionService->current();

          try {
               $this->productService->add($request);
               View::redirect("/products");
          } catch (ValidationException $exception) {
               View::renderProduct("Barang/add", [
                    "title" => "Tambah Barang",
                    "name" => $session->userId,
                    "error" => $exception->getMessage()
               ]);
          }
     }

     public function edit(int $id)
     {
          $product = $this->productRepository->findById($id);
          $session = $this->sessionService->current();
          View::renderProduct("Barang/edit", [
               "title" => "Edit Product",
               "name" => $session->userId,
               "product" => $product,
          ]);
     }

     public function postEdit()
     {
          $request = new ProductUpdateRequest();
          $request->id = $_POST['product_id'];
          $request->name = $_POST['name'];
          $request->quantity = $_POST['quantity'];
          $request->price = $_POST['price'];

          $current = $this->sessionService->current();

          try {
               $this->productService->updateProduct($request);
               View::redirect("/products");
          } catch (ValidationException $exception) {
               View::renderProduct("Barang/show", [
                    "title" => "Dashboard",
                    "name" => $current->userId,
                    "products" => $this->productService->showAllProducts(),
               ]);
          }
     }

     public function delete(string $id)
     {
          $this->productService->deleteProduct($id);
          View::redirect("/products");
     }
}
