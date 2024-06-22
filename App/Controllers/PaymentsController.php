<?php

namespace Hitek\Slimez\App\Controllers;

use Exception;
use Hitek\Slimez\App\Middlewares\Auth;
use Hitek\Slimez\App\Models\PackagesModel;
use Hitek\Slimez\App\Models\ServerSettingsModel;
use Hitek\Slimez\App\Models\TransactionRecordModel;
use Hitek\Slimez\App\Models\TransactionVpnModel;
use Hitek\Slimez\App\Models\UserModel;
use Hitek\Slimez\App\Models\VirtualAccountModel;
use Hitek\Slimez\App\Models\VpnSubscriptionModel;
use Hitek\Slimez\App\Models\WalletModel;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\LencoPayment;
use Hitek\Slimez\Core\Messaging;
use Hitek\Slimez\Core\MonnifyPayment;
use Hitek\Slimez\Core\PaypalPayment;
use Hitek\Slimez\Core\PaystackPayment;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\SeerbitPayment;
use Hitek\Slimez\Core\Session;
use Hitek\Slimez\Core\WebhookSampleData;

use function PHPUnit\Framework\matches;

class PaymentsController extends BaseController
{
    protected $paymentGateWayObject;

    function __construct()
    {

        $this->paymentGateWayObject =  new SeerbitPayment();
        // /*get the payment gateway been use */
        // $gateWayObj = new ServerSettingsModel();

        // $gateWayData = $gateWayObj
        //     ->setSettingsId("1")
        //     ->selectQuery();
        // /*use the match statement, similar to the switch statement */
        // if (isset($gateWayData['paymentGateWay'])) {
        //     $this->paymentGateWayObject = match ($gateWayData['paymentGateWay']) {
        //         1 => new PaystackPayment(),
        //         2 => new MonnifyPayment(),
        //         3 => new SeerbitPayment(),
        //         4 => new LencoPayment(),
        //         5 => new PaypalPayment(),
        //     };
        // }
    }

    // payment webhook
    public function webhook($param = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Retrieve the request's body
            $input = @file_get_contents("php://input");

            $hooks = json_decode($input, true);

            $this->processTransactionsEvent($hooks);

            // if (isset($hooks['notificationItems'][0]['notificationRequestItem'])) {
            //     /**set the data */
            //     $eventData = $hooks['notificationItems'][0]['notificationRequestItem'];
            //     /**check the event type */
            //     $events = match ($eventData['eventType']) {
            //         /**process the event */
            //         'transaction' => $this->processTransactionsEvent($eventData),
            //         'transaction.recurrent' => $this->processTransactionsRecurrentEvent($eventData),
            //         'transaction.wallet' => $this->processTransactionsWalletEvent($eventData),
            //         'transaction.dispute' => $this->processTransactionsDisputeEvent($eventData),
            //         'transaction.recurring.debit' => $this->processTransactionsRecurringDebitEvent($eventData),
            //         'transaction.recurring.debit' => $this->processTransactionsRecurringDebitEvent($eventData),
            //     };
            //     http_response_code(200);
            //     /**response */
            //     echo json_encode($events);
            //     return;
            // }
            echo json_encode($hooks['notificationItems'][0]['notificationRequestItem']);
            return;
        }
    }

    /**the event data */
    private function processTransactionsEvent(array | object | string $eventData)
    {

        // Convert array to JSON format
        $jsonString = json_encode($eventData, JSON_PRETTY_PRINT);
        if (!is_dir("./logs")) {
            mkdir("./logs/");
        }

        // Specify the file path in the root directory
        $filePath = './logs/events_hooks.json';

        if (file_exists($filePath)) {
            // Read the existing file content
            $existingContent = file_get_contents($filePath);

            // Check if the file is empty or not
            if (empty($existingContent)) {
                // First data, enclose in square brackets
                $jsonString = "[$jsonString]";
            } else {
                // Remove trailing square bracket
                $existingContent = rtrim($existingContent, ']');

                // Append a comma and the new JSON data
                $jsonString = "$existingContent,$jsonString]";
            }

            // Write JSON data to the file
            file_put_contents($filePath, $jsonString, LOCK_EX);

            return $eventData;
        }

        // If the file doesn't exist, create it and enclose the data in square brackets
        file_put_contents($filePath, "[$jsonString]", LOCK_EX);
        return $eventData;
    }

    /**the event data */
    private function processTransactionsRecurrentEvent(array | object | string $eventData)
    {
        // Convert array to JSON format
        $jsonString = json_encode($eventData, JSON_PRETTY_PRINT);
        if (!is_dir("./logs")) {
            mkdir("./logs/");
        }

        // Specify the file path in the root directory
        $filePath = './logs/events_hooks.json';

        if (file_exists($filePath)) {
            // Read the existing file content
            $existingContent = file_get_contents($filePath);

            // Check if the file is empty or not
            if (empty($existingContent)) {
                // First data, enclose in square brackets
                $jsonString = "[$jsonString]";
            } else {
                // Remove trailing square bracket
                $existingContent = rtrim($existingContent, ']');

                // Append a comma and the new JSON data
                $jsonString = "$existingContent,$jsonString]";
            }

            // Write JSON data to the file
            file_put_contents($filePath, $jsonString, LOCK_EX);

            return $eventData;
        }

        // If the file doesn't exist, create it and enclose the data in square brackets
        file_put_contents($filePath, "[$jsonString]", LOCK_EX);
        return $eventData;
    }
    /**the event data */
    private function processTransactionsWalletEvent(array | object | string $eventData)
    {
        // Convert array to JSON format
        $jsonString = json_encode($eventData, JSON_PRETTY_PRINT);
        if (!is_dir("./logs")) {
            mkdir("./logs/");
        }

        // Specify the file path in the root directory
        $filePath = './logs/events_hooks.json';

        if (file_exists($filePath)) {
            // Read the existing file content
            $existingContent = file_get_contents($filePath);

            // Check if the file is empty or not
            if (empty($existingContent)) {
                // First data, enclose in square brackets
                $jsonString = "[$jsonString]";
            } else {
                // Remove trailing square bracket
                $existingContent = rtrim($existingContent, ']');

                // Append a comma and the new JSON data
                $jsonString = "$existingContent,$jsonString]";
            }

            // Write JSON data to the file
            file_put_contents($filePath, $jsonString, LOCK_EX);

            return $eventData;
        }

        // If the file doesn't exist, create it and enclose the data in square brackets
        file_put_contents($filePath, "[$jsonString]", LOCK_EX);
        return $eventData;
    }
    /**the event data */
    private function processTransactionsDisputeEvent(array | object | string $eventData)
    {
        // Convert array to JSON format
        $jsonString = json_encode($eventData, JSON_PRETTY_PRINT);
        if (!is_dir("./logs")) {
            mkdir("./logs/");
        }

        // Specify the file path in the root directory
        $filePath = './logs/events_hooks.json';

        if (file_exists($filePath)) {
            // Read the existing file content
            $existingContent = file_get_contents($filePath);

            // Check if the file is empty or not
            if (empty($existingContent)) {
                // First data, enclose in square brackets
                $jsonString = "[$jsonString]";
            } else {
                // Remove trailing square bracket
                $existingContent = rtrim($existingContent, ']');

                // Append a comma and the new JSON data
                $jsonString = "$existingContent,$jsonString]";
            }

            // Write JSON data to the file
            file_put_contents($filePath, $jsonString, LOCK_EX);

            return $eventData;
        }

        // If the file doesn't exist, create it and enclose the data in square brackets
        file_put_contents($filePath, "[$jsonString]", LOCK_EX);
        return $eventData;
    }
    /**the event data */
    private function processTransactionsRecurringDebitEvent(array | object | string $eventData)
    {
        // Convert array to JSON format
        $jsonString = json_encode($eventData, JSON_PRETTY_PRINT);
        if (!is_dir("./logs")) {
            mkdir("./logs/");
        }

        // Specify the file path in the root directory
        $filePath = './logs/events_hooks.json';

        if (file_exists($filePath)) {
            // Read the existing file content
            $existingContent = file_get_contents($filePath);

            // Check if the file is empty or not
            if (empty($existingContent)) {
                // First data, enclose in square brackets
                $jsonString = "[$jsonString]";
            } else {
                // Remove trailing square bracket
                $existingContent = rtrim($existingContent, ']');

                // Append a comma and the new JSON data
                $jsonString = "$existingContent,$jsonString]";
            }

            // Write JSON data to the file
            file_put_contents($filePath, $jsonString, LOCK_EX);

            return $eventData;
        }

        // If the file doesn't exist, create it and enclose the data in square brackets
        file_put_contents($filePath, "[$jsonString]", LOCK_EX);
        return $eventData;
    }


    /** */
    public function paymentStatus($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            /**get post data */
            $reference = isset($_GET['reference']) ? Security::kenProtectFunc($_GET['reference']) : '';
            $trxref = isset($_GET['trxref']) ? Security::kenProtectFunc($_GET['trxref']) : '';
            $paymentReference = isset($_GET['paymentReference']) ? Security::kenProtectFunc($_GET['paymentReference']) : '';
            /**check the data */
            if (!isset($paymentReference) || !isset($trxref) || !isset($reference)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Empty transaction reference, must not be empty",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            /**check the get veriable for the one that contains data */
            $ref = '';
            if (!empty($paymentReference)) {
                $ref = $paymentReference;
            } else if (!empty($trxref)) {
                $ref = $trxref;
            } else {
                $ref = $reference;
            }
            /**make api call to verify the transaction status */
            $response = $this->paymentGateWayObject->verifyPayment(referenceNumber: $ref);
            /**return response */
            echo Responses::json([
                "status" => "success",
                "message" => "Return transaction state",
                "data" => $response['data']['payments']
            ], Env::SUCCESS_METHOD);
            return;
        }

        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }


    public function mobilePaymentStatus($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            /**check if the transaction was cancelled */
            if(isset($_GET['message']) && isset($_GET['code']) && $_GET['code'] == "S19"){
                /**get post data */
                $reference = isset($_GET['reference']) ? Security::kenProtectFunc($_GET['reference']) : '';
                 /**delete the initiated data from the database */
                /**save transaction to database */
                $vpnTransactionRecord = new TransactionRecordModel();

                $transactionRecord = $vpnTransactionRecord->setTransactionReference($reference)
                    ->selectQuery();
               
                if(!empty($transactionRecord) && $transactionRecord['transactionStatus'] == "initiated"){
                    
               
                /**create object of the transaction vpn model */
                $transactionVpn = new TransactionVpnModel();
                // delete the transaction vpn model
                $transationData = $transactionVpn->setTransactionRecordId($transactionRecord['transId'])->selectQuery();
               
                $userObj = new UserModel();
                $user = $userObj->setUserId($transationData['userId'])->selectQuery();

                $dateDeleted = new \DateTime();
                $datetime = $dateDeleted->format('Y-m-d H:i:s');

                $transactionVpn->deleteQuery();
                /**delete the transaction */
                $vpnTransactionRecord->deleteQuery();

                header("Content-Type: text/html; charset=UTF-8");
                $htmlResponse = "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Transaction Status</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #1B3E31;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px 30px;
                                background-color: #1B3E31;
                                border-radius: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                text-align: left;
                                color: #E5AAA5;
                            }
                            .container h2{
                                color: #E44B3D;
                            }
                            .success-indicator {
                                width: 80px;
                                height: 80px;
                                margin: 0 auto 20px;
                                background-color: red;
                                border-radius: 50%;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            }
                            .success-indicator svg {
                                fill: #fff;
                                width: 50px;
                                height: 50px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                        <div class='success-indicator'>
                        <!-- Animated unsuccessful indicator SVG -->
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                            <path d='M22 11.08V12a10 10 0 1 1-5.93-9.14'></path>
                            <polyline points='22 4 12 14.01 9 11.01'></polyline>
                        </svg>
                    </div>
                            <br>
                            <h2>Transaction Cancelled</h2>
                            <p>Oops! It looks like the transaction has been cancelled.</p>
                            <p>Reference: ".$_GET['reference']."</p>
                            <p>Transation Date: ".$datetime."</p>
                        </div>
                    </body>
                    </html>";
                    Messaging::sendEmail(
                        sender: Env::SMTP_USERNAME,
                        companyName: Env::COMPANY_NAME,
                        recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                        message: $htmlResponse,
                        title: "Transation cancelled"
                    );
                echo $htmlResponse;
                return;
                }
            return;
            }

            $reference = isset($_GET['reference']) ? Security::kenProtectFunc($_GET['reference']) : '';
            $trxref = isset($_GET['trxref']) ? Security::kenProtectFunc($_GET['trxref']) : '';
            $paymentReference = isset($_GET['paymentReference']) ? Security::kenProtectFunc($_GET['paymentReference']) : '';

            /**check the data */
            if (!isset($paymentReference) || !isset($trxref) || !isset($reference)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Empty transaction reference, must not be empty",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            /**check the get variable for the one that contains data */
            $ref = '';
            if (!empty($paymentReference)) {
                $ref = $paymentReference;
            } else if (!empty($trxref)) {
                $ref = $trxref;
            } else {
                $ref = $reference;
            }
            /**make API call to verify the transaction status */
            $response = $this->paymentGateWayObject->verifyPayment(referenceNumber: $ref);



            // On success, construct the HTML response page
            if (strtolower($response['data']['payments']['gatewayMessage']) == 'successful') {

                /**save transaction to database */
                $vpnTransaction = new TransactionRecordModel();

                /**send an email */

                $transactionRecord = $vpnTransaction->setTransactionReference($response['data']['payments']['paymentReference'])
                    ->selectQuery();

                $transactionVpn = new TransactionVpnModel();

                if (!empty($response['data']['payments']['paymentReference'])) {

                    if($transactionRecord['amountExpectedToPay'] <= $response['data']['payments']['amount']){

                    

                    $vpnTransRecord = $transactionVpn->setTransactionRecordId($transactionRecord['transId'])->selectQuery();


                    $userData = new UserModel();


                    $user = $userData->setUserId($vpnTransRecord['userId'])->selectQuery();

                    

                    $wallet = new WalletModel();
                    // get the wallet
                    $walletData = $wallet->setUserId($user['userId'])->selectQuery();

                    $walletAfter = isset($walletData['wallet_balance']) &&
                        $walletData['wallet_balance'] >= ($response['data']['payments']['amount'] + $response['data']['payments']['fee'])  ?
                        ($walletData['wallet_balance'] - ($response['data']['payments']['amount'] + $response['data']['payments']['fee'])) : '';

                        $amountToPay = $response['data']['payments']['amount'] + $response['data']['payments']['fee'];
                       
                    $transactionVpn->setUserId($user['userId'])
                        ->setAmountPaid($amountToPay)
                        ->setTransactionReference($reference)
                        ->setTransactionStatus($response['data']['payments']['gatewayMessage']);


                    $vpnTransaction->setTransactionStatus(strtolower($response['data']['payments']['gatewayMessage']))
                                    ->setTransactionType('vpn_sub')
                                    ->setTransactionSessionId($response['data']['payments']['gatewayref'])
                                    ->setTransactionFee($response['data']['payments']['fee'])
                                    ->setWalletBalanceAfter($walletAfter)
                                    ->setAmountPaid($amountToPay);
                
                                    

                    $vpnTransaction->updateQuery();
                    $transactionVpn->updateQuery();

                    $transactionVpnSelect = $transactionVpn->selectQuery();

                    $dateDeleted = new \DateTime();
                    $datetime = $dateDeleted->format('Y-m-d H:i:s');

                    
                    

                    /**
                     * fill in the transaction data
                     */
                    $subscription = new VpnSubscriptionModel();
                    $subscription->setUserId($user['userId'])
                                ->setAmount($response['data']['payments']['amount'])
                                ->setDuration($transactionVpnSelect['duration'])
                                ->setSubType("KVPNSmart")
                                ->setStartDate($datetime)
                                ->setEndDate($datetime);

                                

                    $subscription->updateQuery();

                    header("Content-Type: text/html; charset=UTF-8");
                    $htmlResponse = "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Transaction Status</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #1B3E31;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px 30px;
                                background-color: #1B3E31;
                                border-radius: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                text-align: left;
                                color: #E5AAA5;
                            }
                            .success-indicator {
                                width: 80px;
                                height: 80px;
                                margin: 0 auto 20px;
                                background-color: #4caf50;
                                border-radius: 50%;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            }
                            .container h2{
                                color: #E44B3D;
                            }
                            .success-indicator svg {
                                fill: #fff;
                                width: 50px;
                                height: 50px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='success-indicator'>
                                <!-- Animated success indicator SVG -->
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M22 11.08V12a10 10 0 1 1-5.93-9.14'></path><polyline points='22 4 12 14.01 9 11.01'></polyline></svg>
                            </div>
                            <br>
                            <h2>Thank you, Payment Successful and your package is activated</h2>
                            <p>Currency: " . $response['data']['payments']['currency'] . "</p>
                            <p>Amount: " . $response['data']['payments']['amount'] . "</p>
                            <p>Fee: " . $response['data']['payments']['fee'] . "</p>
                            <p>Date: " . $response['data']['payments']['completionTime'] . "</p>
                            <p>Beneficiary: " . $response['data']['payments']['businessName'] . "</p>
                            <p>Payment Status: " . $response['data']['payments']['gatewayMessage'] . "</p>
                            <p>Payment Reference: " . $response['data']['payments']['paymentReference'] . "</p>
                            <p>Session Id: " . $response['data']['payments']['gatewayref'] . "</p>
                            <p>Payment Channel: " . $response['data']['payments']['channelType'] . "</p>
                            <p>Subscription Duration: " . $transactionVpnSelect['duration'] . " Month(s)</p>
                            
                        </div>
                    </body>
                    </html>";
            
                    // Return the HTML response
                Messaging::sendEmail(
                    sender: Env::SMTP_USERNAME,
                    recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                    message: $htmlResponse,
                    companyName: Env::COMPANY_NAME,
                    title: 'Subscription transaction successful',
                );

                // Set appropriate headers to indicate that the response contains HTML content
                
                echo $htmlResponse;
                return;
                 }
               }
               return;
            }
        }

        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong request method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }


    /**transfer payout */
    public function payoutStatus($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {


            return;
        }

        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    /**transfer payout status */
    public function payout($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login ',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /*check if the api key is valid */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**get post data */
            $amount = isset($_POST['amount']) ? Security::kenProtectFunc($_POST['amount']) : '';
            $currencyCode = isset($_POST['currency_code']) ? Security::kenProtectFunc($_POST['currency_code']) : '';
            $destinationBankCode = isset($_POST['destinationBankCode']) ? Security::kenProtectFunc($_POST['destinationBankCode']) : '';
            $destinationAccountNumber = isset($_POST['destinationAccountNumber']) ? Security::kenProtectFunc($_POST['destinationAccountNumber']) : '';
            $destinationAccountName = isset($_POST['destinationAccountName']) ? Security::kenProtectFunc($_POST['destinationAccountName']) : '';
            $narration = isset($_POST['narration']) ? Security::kenProtectFunc($_POST['narration']) : '';
            /**check the payment gateway activated */
            if (empty($amount) || empty($destinationBankCode) || empty($currencyCode) || empty($destinationAccountNumber) || empty($destinationAccountName) || empty($narration)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "All the fields must be filled out, the BVN can be just a mobile number, but must not be empty",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
            /**prepare the post data to be sent to the server */
            $postParams = [
                "amount" => $amount,
                "currencyCode" => $currencyCode,
                "destinationBankCode" => $destinationBankCode,
                "destinationAccountNumber" => $destinationAccountNumber,
                "destinationAccountName" => $destinationAccountName,
                "narration" => $narration
            ];
            /**call the payment link method */
            $response = $this->paymentGateWayObject->transferOut(postData: $postParams);

            echo json_encode($response);
            return;
        }

        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    /**generate virtual accounts */
    public function generateVirtualAccount($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login ',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /*check if the api key is valid */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**get post data */
            $currencyCode = isset($_POST['currency_code']) ? Security::kenProtectFunc($_POST['currency_code']) : '';
            $country_code = isset($_POST['country_code']) ? Security::kenProtectFunc($_POST['country_code']) : '';
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $firstname = isset($_POST['firstname']) ? Security::kenProtectFunc($_POST['firstname']) : '';
            $lastname = isset($_POST['lastname']) ? Security::kenProtectFunc($_POST['lastname']) : '';
            $bvn = isset($_POST['bvn']) ? Security::kenProtectFunc($_POST['bvn']) : '';
            /**check the payment gateway activated */
            if (empty($currencyCode) || empty($country_code) || empty($email) || empty($firstname) || empty($lastname) || empty($bvn)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "All the fields must be filled out, the BVN can be just a mobile number, but must not be empty",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
            /*check the validity of the email */
            if (!Security::emailRegularExpression($email)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Wrong email address entered",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
            /**prepare the post data to be sent to the server */
            $postParams = [
                "currencyCode" => $currencyCode,
                "countryCode" => $country_code,
                "email" => $email,
                "firstName" => $firstname,
                "lastName" => $lastname,
                "bvn" => $bvn
            ];
            /**call the payment link method */
            try {

                /*save the data to database*/
                $virtualAccount = new VirtualAccountModel();
                /**get user data from session */
                $user = json_decode(Session::get('user'), true);
                /**set the setters for the virtual account creation model */
                $virtualAccount->setUserId($user['userId']);


                /**first check if the account exists already else insert it */
                $getAccount = $virtualAccount->selectQuery();
                /**check if the user exist */
                if (!empty($getAccount)) {
                    $postParams['gateWayValidate'] = $getAccount['gatewayProvider'];
                }
                /**process the api call */
                $response = $this->paymentGateWayObject->virtualAccount(postData: $postParams);

                /**check the response */
                if (!$response) {
                    echo Responses::json([
                        "status" => "failed",
                        "message" => "Virtual account data already exist",
                        "data" => []
                    ], Env::NOT_ACCEPTABLE);
                    return;
                }
                /**verify account generation */
                if (!isset($response['bankName'])) {
                    echo Responses::json([
                        "status" => "failed",
                        "message" => "Virtual account data not ready",
                        "data" => []
                    ], Env::NOT_ACCEPTABLE);
                    return;
                }
                /**insert the data */
                $virtualAccount
                    ->setVirtualId(Security::genUuid())
                    ->setAccountName($response['accountName'])
                    ->setBankName($response['bankName'])
                    ->setAccountNumber($response['accountNumber'])
                    ->setAccountReference($response['accountReference'])
                    ->setGatewayProvider($response['gatewayProvider']);

                $inserted =  $virtualAccount->insertQuery();
                /**check if there was an insertion error */
                if (!$inserted) {
                    echo Responses::json([
                        "status" => "failed",
                        "message" => "Error occord why inserting data",
                        "data" => []
                    ], Env::NOT_ACCEPTABLE);
                    return;
                }

                echo Responses::json([
                    "status" => "success",
                    "message" => "Your account is created successfully",
                    "data" => $response,
                ], Env::SUCCESS_METHOD);
                return;
            } catch (Exception $e) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => $e->getMessage() . " IN LINE: " . $e->getLine() . " IN FILE: " . $e->getFile(),
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
        }

        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }


    /** process payments */
    public function payment($param = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login ',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /*check if the api key is valid */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**get post data */
            $bvn = isset($_POST['bvn']) ? Security::kenProtectFunc($_POST['bvn']) : '';
            $amount = isset($_POST['amount']) ? Security::kenProtectFunc($_POST['amount']) : '';
            $countryCode = isset($_POST['country_code']) ? Security::kenProtectFunc($_POST['country_code']) : '';
            $currencyCode = isset($_POST['currency_code']) ? Security::kenProtectFunc($_POST['currency_code']) : '';
            $firstName = isset($_POST['firstname']) ? Security::kenProtectFunc($_POST['firstname']) : '';
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $lastName = isset($_POST['lastname']) ? Security::kenProtectFunc($_POST['lastname']) : '';
            $narration = isset($_POST['narration']) ? Security::kenProtectFunc($_POST['narration']) : '';
            $packageId = isset($_POST['packageId']) ? Security::kenProtectFunc($_POST['packageId']) : '';
            $duration = isset($_POST['duration']) ? Security::kenProtectFunc($_POST['duration']) : '';
            /**check the payment gateway activated */
            if (empty($bvn) || empty($amount) || empty($countryCode) || empty($currencyCode) || empty($firstName) || empty($email) || empty($lastName) || empty($narration) || empty($packageId) || empty($duration)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "All the fields must be filled out, the BVN can be just a mobile number, but must not be empty",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
            /*check the validity of the email */
            if (!Security::emailRegularExpression($email)) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Wrong email address entered",
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }
            /**check amount */
            if ($amount < Env::LEAST_AMOUNT_ACCEPTED_BY_PAYMENT_GATEWAY && strtolower($currencyCode) == "ngn") {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Amount too small to process, must not less than " . Env::LEAST_AMOUNT_ACCEPTED_BY_PAYMENT_GATEWAY,
                    "data" => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            

            /**prepare the data to be posted to the payment gateway endpoint */

            $postData = [
                'bvn' => $bvn,
                'amount' => $amount,
                'countyCode' => $countryCode,
                'currencyCode' => $currencyCode,
                'firstName' => $firstName,
                'email' => $email,
                'lastName' => $lastName,
                'callbackUrl' =>  Env::PAYMENT_CALLBACK_URL,
                'oncloseUrl' => Env::PAYMENT_CLOSED_URL,
                'narration' => $narration,
            ];

            
            /**call the payment link method */
            $response = $this->paymentGateWayObject->paymentLink(postData: $postData);
            
            /*check if data was reurned */
            if (!$response) {
                echo Responses::json([
                    "status" => "failed",
                    "message" => "Error generating payment link",
                    "data" => $response,
                ]);
                return;
            }
            // get user data from session
            $user = json_decode(Session::get('user'), true);
            /**insert data to the database */
            $transaction = new TransactionVpnModel();

            $wallet = new WalletModel();

            // get the wallet
            $walletData = $wallet->setUserId($user['userId'])->selectQuery();

            if (!empty($walletData)) {
                $transaction->setUserId($user['userId'])
                    ->setVpnId(Security::genUuid())
                    ->setTransactionRecordId(Security::genUuid())
                    ->setDuration($duration)
                    ->setTransactionCurrency($currencyCode)
                    ->setAmountExpectedToPay($amount)
                    ->setTransactionNarration($narration)
                    ->setTransactionReference($response['reference'])
                    ->setTransactionStatus("initiated")
                    ->setWalletBalanceBefore($walletData['wallet_balance']);
                $transaction->insertQuery(isTrans: true);
            }

            /**insert subscription package */
            $package = new PackagesModel();

           $packageData =  $package->setPackageId($packageId)->selectQuery();

           if(!empty($packageData)){
             $subVpn = new VpnSubscriptionModel();
             $subVpnData = $subVpn->setUserId($user['userId'])->selectQuery(); 

             if(isset($subVpnData) && $subVpnData['userId'] == $user['userId']){
                $subVpn->setAmount($packageData['amount'])
                        ->setDuration($packageData['duration'])
                        ->setSubId($packageData['packageId'])
                        ->setSubType("kvpnsmart");

                $subVpn->updateQuery();
             }

           }


            /*return a successfull message */
            echo Responses::json([
                "status" => "success",
                "message" => "Pay to the account generated for you",
                "data" => ['checkoutUrl' => $response['redirectLink']]
            ]);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    public function getBanks($param = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login ',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /*check if the api key is valid */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**check the payment gateway activated */
            // $response = $this->paymentGateWayObject->buytime();

            //echo json_encode($response);
            return;

            if (!isset($response)) {
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Something went wrong',
                    'data' => []
                ], Env::METHOD_NOT_ALLOWED);
                return;
            }

            if (empty($response)) {
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Failed getting the banks',
                    'data' => []
                ], Env::METHOD_NOT_ALLOWED);
                return;
            }
            echo Responses::json([
                'status' => 'success',
                'message' => 'Banks fetched',
                'data' => $response,
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }
}
