<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
     public function testGuest()
     {
          View::render("Home/index", [
               "title" => "Stock Manager"
          ]);

          $this->expectOutputRegex("[Selamat datang]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Register]");
     }
}
