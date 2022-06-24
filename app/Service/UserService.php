<?php

namespace Iqbal\StockManager\Service;

use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Model\UserRegisterRequest;
use Iqbal\StockManager\Model\UserRegisterResponse;
use Iqbal\StockManager\Repository\UserRepository;

class UserService
{
     private UserRepository $userRepository;

     public function __construct(UserRepository $userRepository)
     {
          $this->userRepository = $userRepository;
     }

     public function register(UserRegisterRequest $request): UserRegisterResponse
     {
          $this->validateUserRegsiterRequest($request);

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
               Database::rollBackTrasaction();
               throw $exception;
          }
     }

     private function validateUserRegsiterRequest(UserRegisterRequest $request)
     {
          if (($request->id == null || "") && ($request->username == null || "") && ($request->password == null || "") && ($request->ulangiPassword == null || "") && ($request->email == null || "")) {
               throw new ValidationException("Id, username, password, email tidak boleh kosong");
          }
     }
}
