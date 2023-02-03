<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Domain\User;
use PDO;

class UserRepository
{
     private PDO $connection;

     public function __construct(PDO $connection)
     {
          $this->connection = $connection;
     }

     public function save(User $user): User
     {
          $statement = $this->connection->prepare("INSERT INTO users(id, username, password, email) VALUES (?, ?, ?, ?)");
          $statement->execute([$user->id, $user->username, $user->password, $user->email]);

          return $user;
     }

     public function findById(string $id): ?User
     {
          $statement = $this->connection->prepare("SELECT id, username, password, email FROM users WHERE id = ?");
          $statement->execute([$id]);

          try {
               if ($row = $statement->fetch()) {
                    $user = new User();
                    $user->id = $row['id'];
                    $user->username = $row['username'];
                    $user->password = $row['password'];
                    $user->email = $row['email'];

                    return $user;
               } else {
                    return null;
               }
          } finally {
               $statement->closeCursor();
          }
     }

     public function deleteAll()
     {
          $this->connection->exec("DELETE FROM users");
     }

     public function updatePassword(User $user): User
     {
          $statement = $this->connection->prepare("UPDATE users SET password = ? WHERE id = ?");
          $statement->execute([$user->password, $user->id]);
          return $user;
     }
}
