<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
     private UserService $userService;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userService = new UserService($this->userRepository);

          $this->userRepository->deleteAll();
     }

     public function testRegisterSuccess()
     {
          $request = new UserRegisterRequest();
          $request->id = "budi";
          $request->username = "Budi";
          $request->password = "qwerty";
          $request->ulangiPassword = "qwerty";
          $request->email = "budi@gmail.com";

          $response = $this->userService->register($request);

          $this->assertEquals($request->id, $response->user->id);
          $this->assertEquals($request->username, $response->user->username);
          $this->assertNotEquals($request->ulangiPassword, $response->user->password);
          $this->assertTrue(password_verify($request->ulangiPassword, $response->user->password));
     }

     public function testRegisterFaild()
     {
          $this->expectException(ValidationException::class);

          $request = new UserRegisterRequest();
          $request->id = "";
          $request->username = "";
          $request->password = "";
          $request->ulangiPassword = "";
          $request->email = "";

          $this->userService->register($request);
     }

     public function testRegisterUserDuplicate()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $this->expectException(ValidationException::class);

          $request = new UserRegisterRequest();
          $request->id = "budi";
          $request->username = "Budi";
          $request->password = "asdfgh";
          $request->ulangiPassword = "asdfgh";
          $request->email = "budi@gmail.com";

          $this->userService->register($request);
     }

     public function testRegisterPasswordNotSame()
     {
          $this->expectException(ValidationException::class);

          $request = new UserRegisterRequest();
          $request->id = "budi";
          $request->username = "Budi";
          $request->password = "asdfgh";
          $request->ulangiPassword = "qwerty";
          $request->email = "budi@gmail.com";

          $this->userService->register($request);
     }

     public function testRegisterEmailFaild()
     {
          $this->expectException(ValidationException::class);
          $request = new UserRegisterRequest();
          $request->id = "budi";
          $request->username = "Budi";
          $request->password = "qwerty";
          $request->ulangiPassword = "qwerty";
          $request->email = "budi@gmai";

          $this->userService->register($request);
     }
}
