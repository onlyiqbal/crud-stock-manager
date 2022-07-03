<?php

namespace Iqbal\StockManager\Middleware;

require_once __DIR__ . "/../Helper/helper.php";

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;
use PHPUnit\Framework\TestCase;

class MustNotLoginMiddlewareTest extends TestCase
{
     private MustNotLoginMiddleware $middleware;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;

     protected function setUp(): void
     {
          $this->middleware = new MustNotLoginMiddleware();
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();

          putenv("mode=test");
     }

     public function testBeforeGuest()
     {
          $user = new User();
          $user->id = 'iqbal';
          $user->username = 'Iqbal';
          $user->password = password_hash('qwerty', PASSWORD_BCRYPT);
          $user->email = "iqbal@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = $user->id;
          $this->sessionRepository->save($session);

          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, SessionService::$SECRET_KEY, "HS256");

          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $this->middleware->before();
          $this->expectOutputRegex("[Location: /products]");
     }
}
