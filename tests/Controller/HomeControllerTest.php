<?php

namespace Iqbal\StockManager\Controller;

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
     private HomeController $homeController;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;
     private SessionService $sessionsService;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();

          $this->sessionsService = new SessionService($this->sessionRepository, $this->userRepository);
          $this->homeController = new HomeController();
     }

     public function testGuest()
     {
          $this->homeController->index();

          $this->expectOutputRegex("[Selamat Datang]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Register]");
     }

     public function testUserLogin()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $sessions = new Session();
          $sessions->id = uniqid();
          $sessions->userId = $user->id;
          $this->sessionRepository->save($sessions);

          $payload = [
               "session_id" => $sessions->id,
               "username" => $sessions->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, $this->sessionsService::$SECRET_KEY, "HS256");

          $_COOKIE[$this->sessionsService::$COOKIE_NAME] = $jwt;

          $this->homeController->index();

          $this->expectOutputRegex("[Barang]");
          $this->expectOutputRegex("[My Profile]");
          $this->expectOutputRegex("[Logout]");
     }
}
