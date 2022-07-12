<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Iqbal\StockManager\App\Router;
use Iqbal\StockManager\Config\Database;
use Iqbal\StockManager\Controller\HomeController;
use Iqbal\StockManager\Controller\ProductController;
use Iqbal\StockManager\Controller\UserController;
use Iqbal\StockManager\Middleware\MustLoginMiddleware;
use Iqbal\StockManager\Middleware\MustNotLoginMiddleware;

Database::getConnection("prod");

//Home Controller
Router::add("GET", "/", HomeController::class, "index", []);
Router::add("GET", "/products", HomeController::class, "index", [MustLoginMiddleware::class]);
//User Controller
Router::add("GET", "/users/register", UserController::class, "register", [MustNotLoginMiddleware::class]);
Router::add("POST", "/users/register", UserController::class, "postRegister", [MustNotLoginMiddleware::class]);
Router::add("GET", "/users/login", UserController::class, "login", [MustNotLoginMiddleware::class]);
Router::add("POST", "/users/login", UserController::class, "postLogin", [MustNotLoginMiddleware::class]);
Router::add("GET", "/users/logout", UserController::class, "logout", [MustLoginMiddleware::class]);
Router::add("GET", "/users/profile", UserController::class, "profile", [MustLoginMiddleware::class]);
Router::add("POST", "/users/profile", UserController::class, "update", [MustLoginMiddleware::class]);
//Product Controller
Router::add("GET", "/products/add", ProductController::class, "add", [MustLoginMiddleware::class]);
Router::add("POST", "/products/add", ProductController::class, "postAdd", [MustLoginMiddleware::class]);
Router::add("GET", "/products/edit/([0-9a-zA-Z]*)", ProductController::class, "edit", [MustLoginMiddleware::class]);
Router::add("GET", "/products/delete/([0-9a-zA-Z]*)", ProductController::class, "delete", [MustLoginMiddleware::class]);
Router::run();
