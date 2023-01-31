<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserLoginRequest;
use Iqbal\StockManager\Model\UserLoginResponse;
use Iqbal\StockManager\Model\UserProfileUpdateRequest;
use Iqbal\StockManager\Model\UserProfileUpdateResponse;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Model\UserRegisterResponse;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;

class UserService
{
     private UserRepository $userRepository;
     private SessionService $sessionService;

     public function __construct(UserRepository $userRepository)
     {
          $this->userRepository = $userRepository;
          $sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionService = new SessionService($sessionRepository, $this->userRepository);
     }

     public function register(UserRegisterRequest $request): UserRegisterResponse
     {
          $this->validateUserRegisterRequest($request);

          $user = $this->userRepository->findById($request->id);
          if ($user != null) {
               throw new ValidationException("User yang Anda masukan sudah terdaftar");
          }

          $id = $request->id;
          $username = $request->username;
          $password = $request->password;
          $ulangiPassword = $request->ulangiPassword;
          $email = $request->email;

          if ($password != $ulangiPassword) {
               throw new ValidationException("Password harus sama");
          }
          if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
               throw new ValidationException("Format email salah");
          }

          try {
               Database::beginTransaction();

               $user = new User();
               $user->id = $id;
               $user->username = $username;
               $user->password = password_hash($ulangiPassword, PASSWORD_BCRYPT);
               $user->email = $email;
               $this->userRepository->save($user);

               $response = new UserRegisterResponse();
               $response->user = $user;

               Database::commitTransaction();

               return $response;
          } catch (ValidationException $exception) {
               Database::rollBackTransaction();
               throw $exception;
          }
     }

     private function validateUserRegisterRequest(UserRegisterRequest $request)
     {
          if (($request->id == null || "") && ($request->username == null || "") && ($request->password == null || "") && ($request->ulangiPassword == null || "") && ($request->email == null || "")) {
               throw new ValidationException("Id, username, password, email tidak boleh kosong");
          }
     }

     public function login(UserLoginRequest $request): UserLoginResponse
     {
          $this->validateUserLoginRequest($request);
          $user = $this->userRepository->findById($request->username);
          if ($user == null) {
               throw new ValidationException("Username atau password salah");
          }

          if (password_verify($request->password, $user->password)) {
               $response = new UserLoginResponse();
               $response->user = $user;

               return $response;
          }
     }

     private function validateUserLoginRequest(UserLoginRequest $request)
     {
          if (($request->username == null || "") && ($request->password == null || "")) {
               throw new ValidationException("Username atau password tidak boleh kosong");
          }
     }

     public function updatePassword(UserProfileUpdateRequest $request)
     {
          $this->validateUserUpdateRequest($request);

          try {
               Database::beginTransaction();
               $session = $this->sessionService->current();
               $user = $this->userRepository->findById($session->userId);

               if ($request->old_password != password_verify($request->old_password, $user->password)) {
                    throw new ValidationException("Password lama salah");
               } else if ($request->new_password != $request->repeat_new_password) {
                    throw new ValidationException("Password baru salah");
               }

               $user->password = password_hash($request->repeat_new_password, PASSWORD_BCRYPT);
               $this->userRepository->updatePassword($user);

               Database::commitTransaction();

               $response = new UserProfileUpdateResponse();
               $response->user = $user;
               return $response;
          } catch (ValidationException $exception) {
               Database::rollBackTransaction();
               throw $exception;
          }
     }

     private function validateUserUpdateRequest(UserProfileUpdateRequest $request)
     {
          if (($request->old_password == "" || null) || ($request->new_password == "" || null) || ($request->repeat_new_password == "" || null)) {
               throw new ValidationException("Form tidak boleh kosong");
          }
     }
}
