<?php

namespace Iqbal\StockManager\App {
     function header(string $value)
     {
          echo "$value";
     }
}

namespace Iqbal\StockManager\Service {
     function setcookie(string $name, string $value)
     {
          echo "$name: $value";
     }
}
