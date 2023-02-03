<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserLoginRequest;
use Iqbal\StockManager\Model\UserProfileUpdateRequest;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;
use Iqbal\StockManager\Service\SessionService;
use Iqbal\StockManager\Service\UserService;

class UserController
{
     private UserRepository $userRepository;
     private UserService $userService;
     private SessionService $sessionService;
     private SessionRepository $sessionRepository;

     public function __construct()
     {
          $connection = Database::getConnection();
          $this->userRepository = new UserRepository($connection);
          $this->userService = new UserService($this->userRepository);

          $this->sessionRepository = new SessionRepository($connection);
          $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);
     }

     public function register()
     {
          View::render("User/register", [
               "title" => "Register user baru"
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
               $response = $this->userService->login($request);
               $this->sessionService->create($response->user->id);
               View::redirect("/products");
          } catch (ValidationException $exception) {
               View::render("User/login", [
                    "title" => "User login",
                    "error" => $exception->getMessage()
               ]);
          }
     }

     public function logout()
     {
          $session = $this->sessionService->current();
          $this->sessionService->destroy($session->id);
          View::redirect("/");
     }

     public function profile()
     {
          $session = $this->sessionService->current();
          $user = $this->userRepository->findById($session->userId);
          View::render("User/profile", [
               "title" => "User Profile",
               "name" => $session->userId,
               "user" => $user
          ]);
     }

     public function update()
     {
          $request = new UserProfileUpdateRequest();
          $request->old_password = $_POST['old'];
          $request->new_password = $_POST['new'];
          $request->repeat_new_password = $_POST['repeat_new'];

          $session = $this->sessionService->current();
          $user = $this->userRepository->findById($session->userId);

          try {
               $this->userService->updatePassword($request);
               View::render("User/update", [
                    "title" => "User Update",
                    "name" => $session->userId
               ]);
          } catch (ValidationException $exception) {
               View::render("User/profile", [
                    "title" => "User Profile",
                    "name" => $session->userId,
                    "user" => $user,
                    "error" => $exception->getMessage()
               ]);
          }
     }
}
