<?php

namespace Hitek\Slimez\App\Controllers;

use Exception;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\App\Models\PackagesModel;
use Hitek\Slimez\App\Models\VpnSubscriptionModel;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\Exceptions;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Session;

class VpnController extends BaseController
{

    public function subscribe($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only POST method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }

        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
        $sub_d = isset($_POST['subid']) ? Security::kenProtectFunc($_POST['subid']) : '';

        if (!Security::emailRegularExpression($email)) {
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong email, please enter a valid email to proceed',
            ], Env::NOT_ACCEPTABLE); // Correct use of HTTP status code for bad request
            return;
        }

        if (empty($sub_d)) {
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Empty package, please select a package',
            ], Env::NOT_ACCEPTABLE); // Bad request due to missing package selection
            return;
        }

        try {
            $packagesObj = new PackagesModel();
            $subscriptionObj = new VpnSubscriptionModel();
            $now = new \DateTime();
            $time = $now->format('Y-m-d H:i:s');
            // Convert the formatted string back to a DateTime object to ensure accuracy
            $dateTime = new \DateTime($time);
            // Get the Unix timestamp
            $timestamp = $dateTime->getTimestamp();
           
            $packagesObj->setPackageId($sub_d);
            $packages = $packagesObj->selectQuery();

            if (!$packages) {
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Selected package does not exist',
                ], Env::NOT_FOUND_METHOD); // Package not found
                return;
            }

            $subscriptionObj->setSubId(Security::genUuid())
                ->setUserId('e2f390be-8762-4e73-9752-1ac7b8360f89') // This should ideally be fetched from session or authentication context
                ->setAmount($packages['amount'])
                ->setDuration($packages['duration'])
                ->setStartDate($time);

            $activeSubscription = $subscriptionObj->selectQuery();

            $endDateTimestamp = new \DateTime(!empty($activeSubscription['endDate']) ? $activeSubscription['endDate'] : "00000000");
            
            $endDateTimestampInt = $endDateTimestamp->getTimestamp();
            /**calculate the number of days left */
            $daysLeft = floor(($endDateTimestampInt-$timestamp) / 86400);

            if (!empty($activeSubscription) && $endDateTimestampInt >= $timestamp) {
                echo Responses::json([
                    'status' => "failed",
                    'message' => "You still have an active subscription,".$daysLeft." days remaining",
                ], Env::SUCCESS_METHOD); // Assuming 200 is the code for SUCCESS_METHOD but operation logically failed
                return;
            }

            $subscriptionObj->insertQuery();

            echo Responses::json([
                'status' => "success",
                'message' => "Thank you, your " . $packages['title'] . " package was successful",
            ], Env::SUCCESS_METHOD); // Subscription successful

        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
            echo Responses::json([
                'status' => 'failed',
                'message' => 'An error occurred during the subscription process',
            ], Env::SERVER_ERROR_METHOD); // Internal Server Error
        }
    }


    public function details($params = null)
    {
        echo json_encode($params);
        echo  "by data ";
    }

    /**
     * get the vpn configuration files
     */

    public function configs($params = null)
    {
    }

    /**
     * vpn packages
     */
    public function packages($params = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            /**check if the user is already logged in and then log him out */
            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }

            $packagesObj = new PackagesModel();
            /**
             * setters
             */
            $packagesObj->setStatus(1);

            $packageResponse = $packagesObj->selectQuery(true);


            echo Responses::json(['packages'=>$packageResponse], Env::SUCCESS_METHOD);
            return;
        }

        /**
         * return the response error for the request method
         */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong request method, only GET method is supported for this endpoint',
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }
}
