<?php

/**
 * Author: OAAD GLOBAL
 * Developer: Hitek Financials Ltd
 * Year: 2024
 * Developer Contact: contact@tekfinancials.ng, kennethusiobaifo@yahoo.com
 * Project Name: OAAD-GLOBAL
 * Description: Slimez.
 */

use Hitek\Slimez\App\Controllers\UserController;
use Hitek\Slimez\App\Controllers\VtuController;
use Hitek\Slimez\Core\Router;

/**
 * Define routes and their corresponding controllers and methods.
 */

// Register route
Router::post("/user/signup", 'UserController@signup');

// Login route
Router::post("/user/signin", [UserController::class, 'signin']);

// Logout
Router::post("/user/signout", [UserController::class, 'signout']);

// Airtime route
Router::get("/vtu/airtime", [VtuController::class, 'airtime']);

// Data route
Router::post("/vtu/data", [VtuController::class, 'data']);
