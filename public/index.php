<?php
ini_set('log_errors', 1);
ini_set('error_log', '../logs/app_error.log');

/**
 * Author: Oaad Global
 * Developer: Hitek Financials Ltd
 * Year: 2024
 * Developer Contact: contact@tekfinancials.ng, kennethusiobaifo@yahoo.com
 * Project Name: Slimez
 * Description: Slimez.
 */

require "../vendor/autoload.php";
use Hitek\Slimez\Configs\Env;

session_start();
// Set the appropriate headers for handling sessions and cookies
header('Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *'); // Adjust this according to your needs
header('Access-Control-Allow-Credentials: true'); // Allow credentials (cookies)
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE,PUT, PATCH'); // Adjust allowed methods
header('Access-Control-Allow-Headers: Content-Type, *'); // Adjust allowed headers

setCookie(Env::SYSTEM_NAME, session_id(),  time() + (3600 * Env::COOKIE_EXPIRATION_TIME_IN_HOURS), '/','monolith-php.kvpnsmart.com');

use \Hitek\Slimez\Core\Router;



require "../route/route.php";
/**
 * Error and Exception handling
 */
error_reporting(E_ALL);

set_error_handler('\Hitek\Slimez\Core\Exceptions::errorHandler');
set_exception_handler('\Hitek\Slimez\Core\Exceptions::exceptionHandler');
/**
 * Dispatch the request to the appropriate route handler.
 */
Router::dispatch();
