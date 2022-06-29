<?php

namespace Iqbal\StockManager\App;

class View
{
     public static function render(string $view, $model): void
     {
          require_once __DIR__ . "/../View/" . $view . ".php";
     }

     public static function renderProduct(string $view, $model): void
     {
          require_once __DIR__ . "/../View/header.php";
          require_once __DIR__ . "/../View/" . $view . ".php";
          require_once __DIR__ . "/../View/footer.php";
     }

     public static function redirect(string $url)
     {
          header("Location: $url");
          if (getenv("mode") != "test") {
               exit();
          }
     }
}
