<?php

namespace Iqbal\StockManager\Repository;

use Iqbal\StockManager\Domain\Product;
use PDO;

class ProductRepository
{
     private PDO $connection;

     public function __construct(PDO $connection)
     {
          $this->connection = $connection;
     }

     public function save(Product $product): Product
     {
          $statement = $this->connection->prepare("INSERT INTO products(id, name, quantity, price, update_at) VALUES (?,?,?,?,?)");
          $statement->execute([$product->id, $product->name, $product->quantity, $product->price, $product->update_at]);

          return $product;
     }

     public function showAll()
     {
          $statement = $this->connection->query("SELECT id, name, quantity, price, update_at FROM products");
          return $statement;
     }

     public function findById(string $id): ?Product
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

     public function deleteAll()
     {
          $this->connection->exec("DELETE FROM products");
     }
}
