<?php

namespace Iqbal\StockManager\Controller;

require_once __DIR__ . "/../Helper/helper.php";

use Firebase\JWT\JWT;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
     private UserController $userController;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();
          $this->userController = new UserController();

          putenv("mode=test");
     }

     public function testRegister()
     {
          $this->userController->register();

          $this->expectOutputRegex("[Register user]");
          $this->expectOutputRegex("[Daftar]");
          $this->expectOutputRegex("[Batal]");
     }

     public function testPostRegisterSuccess()
     {
          $_POST['id'] = "budi";
          $_POST['username'] = "Budi";
          $_POST['password'] = "qwerty";
          $_POST['ulangi_password'] = "qwerty";
          $_POST['email'] = "budi@gmail.com";

          $this->userController->postRegister();

          $this->expectOutputRegex("[Location: /users/login]");
     }

     public function testPostRegisterValidationError()
     {
          $_POST['id'] = "";
          $_POST['username'] = "";
          $_POST['password'] = "";
          $_POST['ulangi_password'] = "";
          $_POST['email'] = "";

          $this->userController->postRegister();

          $this->expectOutputRegex("[Id, username, password, email tidak boleh kosong]");
     }

     public function testPostRegisterPasswordNotSame()
     {
          $_POST['id'] = "budi";
          $_POST['username'] = "Budi";
          $_POST['password'] = "qwerty";
          $_POST['ulangi_password'] = "asdfgh";
          $_POST['email'] = "budi@gmail.com";

          $this->userController->postRegister();

          $this->expectOutputRegex("[Password harus sama]");
     }

     public function testPostRegisterEmailNotValid()
     {
          $_POST['id'] = "budi";
          $_POST['username'] = "Budi";
          $_POST['password'] = "qwerty";
          $_POST['ulangi_password'] = "qwerty";
          $_POST['email'] = "budi@gm";

          $this->userController->postRegister();

          $this->expectOutputRegex("[Format email salah]");
     }

     public function testLogin()
     {
          $this->userController->login();

          $this->expectOutputRegex("[Account Login]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Username]");
          $this->expectOutputRegex("[Password]");
     }

     public function testLoginSuccess()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $_POST['username'] = "Budi";
          $_POST['password'] = "qwerty";
          $this->userController->postLogin();

          $this->expectOutputRegex("[Location: /]");
     }

     public function testLoginValidationError()
     {
          $_POST['username'] = "";
          $_POST['password'] = "";
          $this->userController->postLogin();

          $this->expectOutputRegex("[Username atau password tidak boleh kosong]");
     }

     public function testLoginUserNotFound()
     {
          $_POST['username'] = "Iqbal";
          $_POST['password'] = "asdfgh";
          $this->userController->postLogin();

          $this->expectOutputRegex("[Username atau password salah]");
     }

     public function testLogout()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $user->email = "budi@gmail.com";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->userId = "Budi";
          $this->sessionRepository->save($session);

          $paylod = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user",
          ];

          $jwt = JWT::encode($paylod, SessionService::$SECRET_KEY, "HS256");
          $_COOKIE[SessionService::$COOKIE_NAME] = $jwt;

          $this->userController->logout();

          $this->expectOutputRegex("[Location: /]");
          $this->expectOutputRegex("[X-IQBAL-SESSION: ]");
     }
}
