<?php
session_start();
/**
 * Author: Oaad Global
 * Developer: Hitek Financials Ltd
 * Year: 2024
 * Developer Contact: contact@tekfinancials.ng, kennethusiobaifo@yahoo.com
 * Project Name: Slimez
 * Description: Slimez.
 */

require "../vendor/autoload.php";

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
