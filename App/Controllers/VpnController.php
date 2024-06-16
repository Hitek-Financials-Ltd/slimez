<?php

namespace Hitek\Slimez\App\Controllers;

use Exception;
use Hitek\Slimez\App\Models\CurrencyRateModel;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\App\Models\PackagesModel;
use Hitek\Slimez\App\Models\TransactionVpnModel;
use Hitek\Slimez\App\Models\UserModel;
use Hitek\Slimez\App\Models\VpnSubscriptionModel;
use Hitek\Slimez\App\Models\WalletModel;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\Exceptions;
use Hitek\Slimez\Core\Messaging;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Session;

class VpnController extends BaseController
{

    // get currency converstion rates
    public function getRates($params = null){
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only POST method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        // check if the user is logged in
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        $now = new \DateTime();
        $time = $now->format('Y-m-d H:i:s');
       
        //create an object of the model class
        $currencyRateObj = new CurrencyRateModel();
        // set the setters in the model
        $currencyRateObj->setCountry('ngn');
        // get the data
        $currencyData = $currencyRateObj->selectQuery();
        // check if noty empty
        if(!empty($currencyData)){
        // Convert the formatted string back to a DateTime object to ensure accuracy
            $dateTime = new \DateTime($currencyData['updateAt']);
            // Get the Unix timestamp
            $timestamp = $dateTime->getTimestamp();
            // Get the current Unix timestamp
            $currentTimestamp = time();
            // Calculate the difference in seconds, convert it to hours, and round up
            $subtractedTimeInHours = round(($timestamp - $currentTimestamp) / 3600);
         // chcek if the last updated is more than 1 hour and then update the rate
         if($subtractedTimeInHours < Env::RATE_LAST_UPDATED){
            $endPoint = Env::CURRENCY_RATE_BASE_URL."/latest?access_key=".Env::CURRENCY_RATE_API_KEY;
            // make api call
            $response = $this->getVerb(endPoint: $endPoint);
            if(!empty($response['rates'])){
                // set the setters in the model
                $currencyRateObj->setCountry('all');
                // get the data
                $currency = $currencyRateObj->selectQuery(isSelectAll: true);
                // variable
                // update the rate
                    foreach($currency as $curr){
                        foreach($response['rates'] as $keyRate => $valueRate){
                        if(strtoupper($curr['country']) == strtoupper($keyRate)){
                            // set the
                            $currencyRateObj->setCountry(strtoupper($keyRate))
                            ->setUpdateAt($time)
                            ->setRate(number_format($valueRate, 2,'.',''));

                            $currencyRateObj->updateQuery();
                        }
                    }
                }
            }
         }
        }
        // check if the parameter is not empty
        if(isset($params) && !empty($params)){
            $countryCode = $params['currencyCode'];
            
            // set the setters in the model
            $currencyRateObj->setCountry($countryCode);
            // get the data
            $currency = $currencyRateObj->selectQuery();
            
            echo Responses::json([
                'status' => 'success',
                'message' => 'rate fetched successfully',
                'data' => $currency,
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        // set the setters in the model
        $currencyRateObj->setCountry('all');
        // get the data
        $currency = $currencyRateObj->selectQuery(isSelectAll: true);
        echo Responses::json([
            'status' => 'success',
            'message' => 'rates fetched successfully',
            'data' => $currency,
        ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
        return;
    }

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
        $payType = isset($_POST['payType']) ? Security::kenProtectFunc($_POST['payType']) : '';

        if (!Security::emailRegularExpression($email)) {
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong email, please enter a valid email to proceed',
            ], Env::NOT_ACCEPTABLE); // Correct use of HTTP status code for bad request
            return;
        }

         /**get the user details */

         $userData = json_decode(Session::get('user'), true);
         if($userData['email'] != $email){
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
                ->setUserId($userData['userId']) // This should ideally be fetched from session or authentication context
                ->setAmount($packages['amount'])
                ->setSubType("Vpn")
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

            $subscriptionObj->updateQuery();

            // insert transactions data
            if(!empty($payType) && $payType == "paypal"){
                 /**insert data to the database */
            $transaction = new TransactionVpnModel();

            $wallet = new WalletModel();

            // get the wallet
            $walletData = $wallet->setUserId($userData['userId'])->selectQuery();

            $narration = "A ".$packages['duration']." Month duration vpn subscription";
            $reference = "KVP-".Security::OTPGen()."-SM-".time();
            $sessionId = substr(md5($reference = "KVP-".Security::OTPGen()."-SM-".time()), 16);

            $dateDeleted = new \DateTime();
                $datetime = $dateDeleted->format('Y-m-d H:i:s');

                $vpnTypeId = Security::genUuid();

            if (!empty($walletData['userId'])) {
                $transaction->setUserId($userData['userId'])
                    ->setVpnId($vpnTypeId)
                    ->setTransactionRecordId(Security::genUuid())
                    ->setDuration($packages['duration'])
                    ->setTransactionType('vpn')
                    ->setTransactionCurrency("USD")
                    ->setAmountExpectedToPay($packages['amount'])
                    ->setAmountPaid($packages['amount'])
                    ->setWalletBalanceAfter($walletData['wallet_balance'])
                    ->setTransactionNarration($narration)
                    ->setTransactionFee("0.00")
                    ->setTransactionSessionId($sessionId)
                    ->setTransactionTypeId($vpnTypeId)
                    ->setTransactionReference($reference)
                    ->setTransactionStatus("completed")
                    ->setWalletBalanceBefore($walletData['wallet_balance'])
                    ->setCreatedAt($datetime);
                $transaction->insertQuery(isTrans: true);

                // send email of the transaction

                /**setting up email */
            $messageBody = "
            <div style='width: 100%; position: relative'>
              <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
              <h2 style='color: #000000; padding: 5px 0'>Thank you,</h2>
                 <p> A transaction occurred with us at " . ucfirst(strtolower(Env::SYSTEM_NAME)) . " via PayPal chennel, thank you for subscribing to our service.</p>
                 <p>below is the transaction information</p>
                 <p><strong>Channel:</strong> PayPal</p>
                 <p><strong>Amount:</strong> ".$packages['amount']."</p>
                 <p><strong>Currency:</strong> USD</p>
                 <p><strong>Reference:</strong> ".$reference."</p>
                 <p><strong>Date:</strong> ".$datetime."</p>
                 <p><strong>Date:</strong> Completed</p>
                 <p><strong>Package Duration:</strong> ".$packages['duration']."</p>
                 <p><strong>Duration in days:</strong> ".$daysLeft." days</p>
                 <p><strong>Package ends on:</strong> ".$activeSubscription['endDate']."</p>
              </section>
              <br>
              <section style='width: 100%; position: relative; padding: 20px 0; text-align: center; '>
              <p>&copy; " . date('Y', time()) . " | " . Env::COMPANY_NAME . "</p>
              </section>
            </div>
            ";

            $messageBody2 = "
            <div style='width: 100%; position: relative'>
              <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
              <h2 style='color: #000000; padding: 5px 0'>Hi KVPNSmart</h2>
                 <p> A transaction occurred via PayPal chennel</p>
                 <p>below is the transaction information</p>
                 <p><strong>Channel:</strong> PayPal</p>
                 <p><strong>Amount:</strong> ".$packages['amount']."</p>
                 <p><strong>Currency:</strong> USD</p>
                 <p><strong>Reference:</strong> ".$reference."</p>
                 <p><strong>Date:</strong> ".$datetime."</p>
                 <p><strong>Date:</strong> Completed</p>
                 <p><strong>Package Duration:</strong> ".$packages['duration']."</p>
                 <p><strong>Duration in days:</strong> ".$daysLeft." days</p>
                 <p><strong>Package ends on:</strong> ".$activeSubscription['endDate']."</p>
              </section>
              <br>
              <section style='width: 100%; position: relative; padding: 20px 0; text-align: center; '>
              <p>&copy; " . date('Y', time()) . " | " . Env::COMPANY_NAME . "</p>
              </section>
            </div>
            ";
            /**send email */
            Messaging::sendEmail(
                sender: Env::SMTP_USERNAME,
                companyName: Env::COMPANY_NAME,
                recipients: [$email],
                message: $messageBody,
                title: "VPN Subscription transaction"
            );

             /**send email */
            Messaging::sendEmail(
                sender: Env::SMTP_USERNAME,
                companyName: Env::COMPANY_NAME,
                recipients: ['contact@kvpnsmart.com'],
                message: $messageBody2,
                title: "A subscription occurred at kvpnsmart"
            );


            }


            }

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
