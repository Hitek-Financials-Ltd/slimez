<?php

/**
 * Author: Hitek Financials Ltd
 * Developer: Hitek Financials Ltd
 * Year: 2024
 * Developer Contact: contact@tekfinancials.ng, kennethusiobaifo@yahoo.com
 * Project Name: Hitek Financials Ltd (Slimez Framework)
 * Description: Slimez.
 */

use Hitek\Slimez\App\Controllers\PaymentsController;
use Hitek\Slimez\App\Controllers\UserController;
use Hitek\Slimez\App\Controllers\VtuController;
use Hitek\Slimez\App\Controllers\VpnController;
use Hitek\Slimez\Core\Router;
use Illuminate\Support\Facades\Route;

/**
 * Define routes and their corresponding controllers and methods.
 */

// Register route
Router::post("/user/signup", 'UserController@signup');
// Login route
Router::post("/user/signin", [UserController::class, 'signin']);
// Profile route
Router::post("/user/profile", [UserController::class, 'profile']);
// Delete account
Router::post("/user/delete_account", [UserController::class, 'deleteAccount']);
// verify account 
Router::post("/user/verify_account", [UserController::class, 'verifyAccount']);
// OTP sender
Router::post("/user/otp_sender", [UserController::class, 'otpSender']);
// change password route
Router::post("/user/change_password", [UserController::class, 'changePassword']);
// reset password route
Router::post("/user/reset_password", [UserController::class, 'resetPassword']);
// update account route
Router::post("/user/update_account", [UserController::class, 'updateAccount']);
//upload file route
Router::post("/user/upload_file", [UserController::class, 'uploadFile']);
//logout route
Router::post("/user/signout", [UserController::class, 'signout']);

//get the network providers informations
Router::get("/vtu/country/{countryCode}", [VtuController::class, 'getNetworkOperatorsCountry']);
Router::get("/vtu/operators/{countryCode}/{phoneNumber}", [VtuController::class, 'getNetworkOperatorByIso']);
Router::get("/vtu/operator_byid/{operatorId}",[VtuController::class, "getNetworkOperatorByOperatorId"]);

/**vtu endpoints */
Router::post('/vtu/airtime',[VtuController::class, 'airtime']);
Router::post('/vtu/data',[VtuController::class, 'data']);
Router::get('/vtu/status/{transactionId}',[VtuController::class, 'status']);
Router::get('/vtu/mobiledatails/{countryCode}/{phoneNumber}',[VtuController::class, 'numberDetails']);
Router::post('/vtu/electricity',[VtuController::class, 'electricity']);
Router::post('/vtu/education',[VtuController::class, 'education']);
Router::get('/reloadly/balance', [VtuController::class, 'balance']);
/**
 * vpn subscription endpoints 
 */
//vpn subscribe route
Router::post("/vpn/subscribe", [VpnController::class, 'subscribe']);
//vpn details route
Router::post("/vpn/details", [VpnController::class, 'details']);
//vpn configs route
Router::post("/vpn/configs", [VpnController::class, 'configs']);

//get packages route
Router::get("/vpn/packages", [VpnController::class, 'packages']);

/**process payments */
//Router::post("/transactions/events/live", [PaymentsController::class, 'webhook']);
Router::post("/transactions/events", [PaymentsController::class, 'webhook']);
Router::post("/payments/process",[PaymentsController::class, 'payment']);
Router::get("/payments/banks", [PaymentsController::class,"getBanks"]);
Router::get("/payments/status", [PaymentsController::class,"paymentStatus"]);
Router::post("/payments/payout", [PaymentsController::class,"payout"]);
Router::get("/payments/payout/status", [PaymentsController::class,"payoutStatus"]);
Router::post("/virtual_account/create", [PaymentsController::class, "generateVirtualAccount"]);


