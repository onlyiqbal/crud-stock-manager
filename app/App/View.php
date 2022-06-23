<?php

namespace Iqbal\StockManager\App;

class View
{
     public static function renderIndex(string $view, $model): void
     {
          require __DIR__ . "/../View/" . $view . ".php";
     }
}
