<?php

namespace Iqbal\StockManager\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
     public function testRender()
     {
          View::render("Home/index", [
               "title" => "Stock Manager"
          ]);

          $this->expectOutputRegex("[Stock Manager]");
          $this->expectOutputRegex("[Selamat Datang]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Register]");
     }
}
