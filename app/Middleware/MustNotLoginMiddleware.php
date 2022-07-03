<?php

namespace Iqbal\StockManager\Middleware;

use Iqbal\StockManager\App\View;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;

class MustNotLoginMiddleware implements Middleware
{
     private SessionService $sessionService;

     public function __construct()
     {
          $sessionRepository = new SessionRepository(Database::getConnection());
          $userRepository = new UserRepository(Database::getConnection());
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }
     public function before(): void
     {
          $session = $this->sessionService->current();
          if ($session != null) {
               View::redirect("/products");
          }
     }
}
