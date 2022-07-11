<?php

namespace Iqbal\StockManager\Controller;

require_once __DIR__ . "/../Helper/helper.php";

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Product;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Repository\ProductRepository;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
     private ProductController $productController;
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;
     private ProductRepository $productRepository;

     protected function setUp(): void
     {
          $this->productRepository = new ProductRepository(Database::getConnection());
          $this->productRepository->deleteAll();
          $this->productController = new ProductController();
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();

          putenv("mode=test");
     }

     public function testAdd()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionRepository->save($session);

          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, SessionService::$SECRET_KEY, "HS256");
          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $this->productController->add();

          $this->expectOutputRegex("[Tambah Barang]");
          $this->expectOutputRegex("[Tambah]");
     }

     public function testPostAddSuccess()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionRepository->save($session);

          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, SessionService::$SECRET_KEY, "HS256");
          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $_POST['name'] = "Laptop";
          $_POST['quantity'] = 5;
          $_POST['price'] = 1500000;

          $this->productController->postAdd();

          $this->expectOutputRegex("[Location: /products]");
     }

     public function testEdit()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionRepository->save($session);

          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, SessionService::$SECRET_KEY, "HS256");
          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $product = new Product();
          $product->name = "HP";
          $product->quantity = 5;
          $product->price = 1500000;
          $this->productRepository->save($product);

          $products = $this->productRepository->showAll();
          $result = $products->fetch();

          $this->productController->edit($result['id']);

          $this->expectOutputRegex("[Edit Barang]");
     }

     public function testDeleteSuccess()
     {
          $product = new Product();
          $product->name = "HP";
          $product->quantity = 5;
          $product->price = 1500000;
          $this->productRepository->save($product);

          $product = $this->productRepository->showAll();
          $result = $product->fetch();
          $this->productController->delete($result['id']);

          $this->expectOutputRegex("[Location: /products]");
     }
}
