<?php

namespace Iqbal\StockManager\Controller;

require_once __DIR__ . "/../Helper/helper.php";

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
     private UserController $userController;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
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
}
