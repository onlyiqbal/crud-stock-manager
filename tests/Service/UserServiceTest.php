<?php

namespace Iqbal\StockManager\Service;

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserLoginRequest;
use Iqbal\StockManager\Model\UserProfileUpdateRequest;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
     private UserService $userService;
     private UserRepository $userRepository;
     private SessionRepository $sessionsRepository;

     protected function setUp(): void
     {
          $this->sessionsRepository = new SessionRepository(Database::getConnection());
          $this->sessionsRepository->deleteAll();
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();

          $this->userService = new UserService($this->userRepository);
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

     public function testRegisterFailed()
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

     public function testRegisterEmailFailed()
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

     public function testLoginSuccess()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
          $user->email = "budi@gmail.com";

          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = "Budi";
          $request->password = "qwerty";
          $response = $this->userService->login($request);

          $this->assertEquals($user->username, $response->user->username);
          $this->assertTrue(password_verify($response->user->password, $user->password));
     }

     public function testLoginValidationError()
     {
          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = "";
          $request->password = "";
          $this->userService->login($request);
     }

     public function testLoginNotFound()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
          $user->email = "budi@gmail.com";

          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = "iqbal";
          $request->password = "asdfgh";
          $this->userService->login($request);
     }

     public function testUpdatePasswordSuccess()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = "budi";
          $this->sessionsRepository->save($session);
          $paylod = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];
          $jwt = JWT::encode($paylod, SessionService::$SECRET_KEY, "HS256");
          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $request = new UserProfileUpdateRequest();
          $request->old_password = "qwerty";
          $request->new_password = "asdfgh";
          $request->repeate_new_password = "asdfgh";

          $this->userService->updatePassword($request);

          $result = $this->userRepository->findById($user->id);

          $this->assertTrue(password_verify($request->repeate_new_password, $result->password));
     }
}
