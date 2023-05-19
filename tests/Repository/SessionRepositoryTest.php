<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();

          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();

          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);
     }

     public function testSaveSuccess()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionRepository->save($session);

          $result = $this->sessionRepository->findById($session->id);

          $this->assertEquals($result->id, $session->id);
          $this->assertEquals($result->userId, $session->userId);
     }

     public function testDeleteByIdSuccess()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionRepository->save($session);

          $result = $this->sessionRepository->findById($session->id);

          $this->assertEquals($result->id, $session->id);
          $this->assertEquals($result->userId, $session->userId);

          $this->sessionRepository->deleteById($session->id);
          $result = $this->sessionRepository->findById($session->id);

          $this->assertNull($result);
     }

     public function deleteByIdNotFound()
     {
          $result = $this->sessionRepository->deleteById("tidak ada");
          $this->assertNull($result);
     }
}
