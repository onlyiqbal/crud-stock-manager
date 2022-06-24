<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();
     }

     public function testSaveSuccess()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";

          $this->userRepository->save($user);
          $result = $this->userRepository->findById($user->id);

          $this->assertEquals($result->id, $user->id);
          $this->assertEquals($result->username, $user->username);
          $this->assertEquals($result->password, $user->password);
          $this->assertEquals($result->email, $user->email);
     }

     public function testFindByIdNotFound()
     {
          $result = $this->userRepository->findById("tidak ada");
          $this->assertNull($result);
     }
}
