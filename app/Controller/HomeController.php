<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Repository\ProductRepository;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\ProductService;
use Iqbal\StockManager\Service\SessionService;

class HomeController
{
     private SessionService $sessionService;
     private ProductService $productService;

     public function __construct()
     {
          $connection = Database::getConnection();
          $productRepository = new ProductRepository($connection);
          $this->productService = new ProductService($productRepository);

          $userRepository = new UserRepository($connection);
          $sessionRepository = new SessionRepository($connection);
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }

     public function index()
     {
          $user = $this->sessionService->current();
          if ($user == null) {
               View::render("Home/index", [
                    'title' => 'Stock Manager'
               ]);
          } else {
               View::renderProduct("Barang/show", [
                    "title" => "Dashboard",
                    "name" => $user->id,
                    "products" => $this->productService->showAllProducts(),
               ]);
          }
     }
}
