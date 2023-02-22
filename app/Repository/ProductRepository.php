<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Domain\Product;
use PDO;
use PDOStatement;

class ProductRepository
{
     private PDO $connection;

     public function __construct(PDO $connection)
     {
          $this->connection = $connection;
     }

     public function save(Product $product): Product
     {
          $statement = $this->connection->prepare("INSERT INTO products(name, quantity, price) VALUES (?,?,?)");
          $statement->execute([$product->name, $product->quantity, $product->price]);

          return $product;
     }

     public function showAll(): PDOStatement
     {
          $statement = $this->connection->query("SELECT id, name, quantity, price, update_at FROM products");
          return $statement;
     }

     public function findById(int $id): ?Product
     {
          $statement = $this->connection->prepare("SELECT id, name, quantity, price, update_at FROM products WHERE id = ?");
          $statement->execute([$id]);

          try {
               if ($row = $statement->fetch()) {
                    $product = new Product();
                    $product->id = $row['id'];
                    $product->name = $row['name'];
                    $product->quantity = $row['quantity'];
                    $product->price = $row['price'];
                    $product->update_at = $row['update_at'];
                    return $product;
               } else {
                    return null;
               }
          } finally {
               $statement->closeCursor();
          }
     }

     public function update(Product $product): Product
     {
          $statement = $this->connection->prepare("UPDATE products SET name = ?, quantity = ?, price = ?, update_at = current_timestamp() WHERE id = ?");
          $statement->execute([$product->name, $product->quantity, $product->price, $product->id]);

          return $product;
     }

     public function deleteById(string $id): void
     {
          $statement = $this->connection->prepare("DELETE FROM products WHERE id = ?");
          $statement->execute([$id]);
     }

     public function deleteAll(): void
     {
          $this->connection->exec("DELETE FROM products");
     }
}
