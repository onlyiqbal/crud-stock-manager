<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserLoginRequest;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\UserService;

class UserController
{
     private UserService $userService;
     private UserRepository $userRepository;

     public function __construct()
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userService = new UserService($this->userRepository);
     }

     public function register()
     {
          View::render("User/register", [
               "title" => "Register new User"
          ]);
     }

     public function postRegister()
     {
          $request = new UserRegisterRequest();
          $request->id = $_POST['id'];
          $request->username = $_POST['username'];
          $request->password = $_POST['password'];
          $request->ulangiPassword = $_POST['ulangi_password'];
          $request->email = $_POST['email'];

          try {
               $this->userService->register($request);
               View::redirect("/users/login");
          } catch (ValidationException $exception) {
               View::render("User/register", [
                    "title" => "Register user",
                    "error" => $exception->getMessage()
               ]);
          }
     }

     public function login()
     {
          View::render("User/login", [
               "title" => "User login"
          ]);
     }

     public function postLogin()
     {
          $request = new UserLoginRequest();
          $request->username = $_POST['username'];
          $request->password = $_POST['password'];

          try {
               $this->userService->login($request);
               View::redirect("/");
          } catch (ValidationException $exception) {
               View::render("User/login", [
                    "title" => "User login",
                    "error" => $exception->getMessage()
               ]);
          }
     }
}
