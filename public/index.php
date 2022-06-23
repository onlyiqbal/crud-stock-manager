<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Iqbal\StockManager\App\Router;
use Iqbal\StockManager\Controller\HomeController;

Router::add("GET", "/", HomeController::class, "index", []);
Router::run();
