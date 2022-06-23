<?php

namespace Iqbal\StockManager\Controller;

use Iqbal\StockManager\App\View;

class HomeController
{
     public function index()
     {
          View::renderIndex("Home/index", [
               'title' => 'Stock Manager'
          ]);
     }
}
