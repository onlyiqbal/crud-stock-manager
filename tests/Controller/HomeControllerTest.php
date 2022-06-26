<?php

namespace Iqbal\StockManager\Controller;

use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
     private HomeController $homeController;

     protected function setUp(): void
     {
          $this->homeController = new HomeController();
     }

     public function testIndex()
     {
          $this->homeController->index();

          $this->expectOutputRegex("[Selamat Datang]");
          $this->expectOutputRegex("[Login]");
          $this->expectOutputRegex("[Register]");
     }
}
