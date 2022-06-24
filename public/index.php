<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Iqbal\StockManager\App\Router;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Controller\HomeController;
use Iqbal\StockManager\Controller\UserController;

Database::getConnection("prod");

//Home Controller
Router::add("GET", "/", HomeController::class, "index", []);
//User Controller
Router::add("GET", "/users/register", UserController::class, "register", []);
Router::add("POST", "/users/register", UserController::class, "postRegister", []);
Router::run();
