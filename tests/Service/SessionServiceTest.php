<?php

namespace Iqbal\StockManager\Service;

require_once __DIR__ . "/../Helper/helper.php";

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
     private SessionService $sessionService;
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();

          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);
     }

     public function testCreate()
     {
          $session = $this->sessionService->create('budi');
          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($payload, $this->sessionService::$SECRET_KEY, "HS256");

          $this->expectOutputRegex("[X-IQBAL-SESSION: $jwt]");

          $result = $this->sessionRepository->findById($session->id);

          $this->assertEquals("budi", $result->userId);
     }

     public function testDestroy()
     {
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

          $_COOKIE[$this->sessionService::$COOKIE_NAME] = $jwt;

          $this->sessionService->destroy($session->id);

          $this->expectOutputRegex("[X-IQBAL-SESSION: ]");

          $result = $this->sessionRepository->findById($session->id);
          $this->assertNull($result);
     }

     // public function testCurrent()
     // {
     //      $session = $this->sessionService->create("budi");

     //      $resultSession = $this->sessionService->current();
     //      $this->assertEquals($resultSession->id, $session->id);
     // }
}
