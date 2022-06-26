<?php

namespace Iqbal\StockManager\Service;

use Exception;
use Firebase\JWT\JWT;
use Iqbal\StockManager\Domain\Session;
use Iqbal\StockManager\Domain\User;
use Iqbal\StockManager\Exception\ValidationException;
use Iqbal\StockManager\Repository\SessionRepository;
use Iqbal\StockManager\Repository\UserRepository;

class SessionService
{
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;
     public static string $SECRET_KEY = "!@#ghsjuey1234jfnvhgt%^&*(kgjghdg";
     public static string $COOKIE_NAME = "X-IQBAL-SESSION";

     public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
     {
          $this->sessionRepository = $sessionRepository;
          $this->userRepository = $userRepository;
     }

     public function create(string $userId): Session
     {
          $session = new Session();
          $session->id = uniqid();
          $session->userId = $userId;
          $this->sessionRepository->save($session);

          $payload = [
               "session_id" => $session->id,
               "username" => $session->userId,
               "role" => "user"
          ];

          $jwt = JWT::encode($payload, self::$SECRET_KEY, "HS256");

          setcookie(self::$COOKIE_NAME, $jwt, time() + (60 * 60 * 24 * 30), "/");

          return $session;
     }

     public function destroy(string $sessionId)
     {
          $this->sessionRepository->deleteById($sessionId);
          setcookie(self::$COOKIE_NAME, "", 1, "/");
     }

     public function current()
     {
          if ($_COOKIE[self::$COOKIE_NAME]) {
               $jwt = $_COOKIE[self::$COOKIE_NAME];
               try {
                    $payload = JWT::decode($jwt, self::$SECRET_KEY, ['HS256']);
                    $session = new Session();
                    $session->id = $payload->session_id;
                    $session->userId = $payload->username;
                    return $session;
               } catch (ValidationException $exception) {
                    throw new ValidationException("User tidak login");
               }
          } else {
               throw new ValidationException("User tidak login");
          }
     }
}