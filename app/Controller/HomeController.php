<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;

class HomeController
{
     public function index()
     {
          View::render("Home/index", [
               'title' => 'Stock Manager'
          ]);
     }
}
