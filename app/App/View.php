<?php

namespace Iqbal\StockManager\App;

class View
{
     public static function renderIndex(string $view, $model): void
     {
          require __DIR__ . "/../View/" . $view . ".php";
     }

     public static function renderRegister(string $view, $model): void
     {
          require __DIR__ . "/../View/" . $view . ".php";
     }

     public static function redirect(string $url)
     {
          header("Location: $url");
          if (getenv("mode") != "test") {
               exit();
          }
     }
}
