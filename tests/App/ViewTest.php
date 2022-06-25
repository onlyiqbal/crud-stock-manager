<?php

namespace Iqbal\StockManager\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
     public function testRender()
     {
          View::render("Home/index", [
               "title" => "Aplikasi Stock Manager"
          ]);

          $this->expectOutputRegex("[Aplikasi Stock Manager]");
          $this->expectOutputRegex("[Selamat Datang]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Register]");
     }
}
