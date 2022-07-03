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

class MustLoginMiddlewareTest extends TestCase
{
     private MustLoginMiddleware $middleware;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;

     protected function setUp(): void
     {
          $this->middleware = new MustLoginMiddleware();
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();

          putenv("mode=test");
     }

     public function testBeforeGuest()
     {
          $this->middleware->before();
          $this->expectOutputRegex("[Location: /users/login]");
     }
}
