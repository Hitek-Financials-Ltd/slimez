<?php

namespace Hitek\Slimez\App\Controllers;

use Hitek\Slimez\App\Models\OperatorsCountryModel;
use Hitek\Slimez\App\Models\ServerSettingsModel;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\ReloadlyVTUandGiftCard;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Session;

class VtuController extends BaseController
{

    protected $vtuVendorsGateway;

    function __construct()
    {
        /*get the payment gateway been use */
        // $gateWayObj = new ServerSettingsModel();

        // $gateWayData = $gateWayObj
        //     ->setSettingsId("1")
        //     ->selectQuery();
        // /*use the match statement, similar to the switch statement */
        // $this->vtuVendorsGateway = match ($gateWayData['vtuVendor']) {
        //     1 => new ReloadlyVTUandGiftCard(),
        // };
    }

    /**get network operators country */
    public function getNetworkOperatorsCountry($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**fetch the list of countries from a model file */
        $countries = json_decode(OperatorsCountryModel::$country, true);

        if (isset($params) && $params != null) {
            /**loop through the file to get the desired country */
            foreach ($countries as $key => $value) {
                if (strtoupper($countries[$key]['isoName']) == strtoupper(trim($params['countryCode'])) || strtoupper($countries[$key]['currencyCode']) == strtoupper(trim($params['countryCode']))) {
                    echo Responses::json([
                        'status' => "success",
                        'message' => "Countries retrieved",
                        'data' => $countries[$key],
                    ]);
                    return;
                }
            }
        }
        /** */
        echo Responses::json([
            'status' => "success",
            'message' => "Countries retrieved",
            'data' => $countries
        ]);
        return;
    }

    public function getNetworkOperatorByOperatorId($params = null){

        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /**get operators by country */
        if (isset($params) && $params != null) {
            /** */
            if (isset($params['operatorId']) && ($params['operatorId'] != null || $params['operatorId'] != '')) {
                /**get all the operators globally */
                $response = $reloadly->getOperatorsByOperatorId(operatorId: $params['operatorId']);
                /****/
                if (!empty($response) && isset($response)) {
                    if (isset($response['name'])) {
                        echo Responses::json([
                            'status' => "success",
                            'message' => $response['name'] . " network operator retreived successfully",
                            'data' => $response
                        ]);
                        return;
                    }
                    /**there is an error */
                    echo Responses::json([
                        'status' => "failed",
                        'message' =>  $response['message'],
                        'data' => []
                    ]);
                }
                return;
            }
            /** */
            $response = $reloadly->getOperatorsByOperatorId();
            /** */
            if (!empty($response) && isset($response[0])) {
                echo Responses::json([
                    'status' => "success",
                    'message' => "Operators in " . $response[0]['country']['name'] . " retreived successfully",
                    'data' => $response
                ]);
                return;
            }
            /**no operator found*/
            echo Responses::json([
                'status' => "failed",
                'message' => "No operator with the country code " . strtoupper(trim($params['operatorId'])) . " found",
                'data' => $response
            ]);
            return;
        }

        /**get all the operators globally */
        $response = $reloadly->getOperator();
        /** */
        echo Responses::json([
            'status' => "success",
            'message' => "All operators Globally retrieved",
            'data' => $response
        ]);
        return;
    }

    /**get network operators in a given country */
    public function getNetworkOperatorByIso($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /**get operators by country */
        if (isset($params) && $params != null) {
            /** */
            if (isset($params['phoneNumber']) && ($params['phoneNumber'] != null || $params['phoneNumber'] != '')) {
                /**get all the operators globally */
                $response = $reloadly->getOperator(
                    phoneNumberAndISOcode: [
                        'number' => (string)Security::formatMobile(mobile: $params['phoneNumber']),
                        'iso' => strtoupper(trim($params['countryCode'])),
                    ]
                );
                /****/
                if (!empty($response) && isset($response)) {
                    if (isset($response['name'])) {
                        echo Responses::json([
                            'status' => "success",
                            'message' => $response['name'] . " network operator retreived successfully",
                            'data' => $response
                        ]);
                        return;
                    }
                    /**there is an error */
                    echo Responses::json([
                        'status' => "failed",
                        'message' =>  $response['message'],
                        'data' => []
                    ]);
                }
                return;
            }
            /** */
            $response = $reloadly->getOperator(countryISO: strtoupper(trim($params['countryCode'])));
            /** */
            if (!empty($response) && isset($response[0])) {
                echo Responses::json([
                    'status' => "success",
                    'message' => "Operators in " . $response[0]['country']['name'] . " retreived successfully",
                    'data' => $response
                ]);
                return;
            }
            /**no operator found*/
            echo Responses::json([
                'status' => "failed",
                'message' => "No operator with the country code " . strtoupper(trim($params['countryCode'])) . " found",
                'data' => $response
            ]);
            return;
        }

        /**get all the operators globally */
        $response = $reloadly->getOperator();
        /** */
        if(isset($response['content'])){
            echo Responses::json([
                'status' => "success",
                'message' => "All operators Globally retrieved",
                'data' => $response['content']
            ]);
            return;
        }

        if(isset($response['message'])){
            echo Responses::json([
                'status' => "failed",
                'message' => $response['message'],
                'data' => [],
            ]);
            return;
        }

        echo Responses::json([
            'status' => "failed",
            'message' => "Error fetching operators",
            'data' => [],
        ]);
        return; 
    }

    /**
     * get mobile number information
     */
    public function numberDetails($params = null){
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /**prepare the parameters to send */
        if (isset($params) && $params != null) {
            $paramsData = [
                'number' => $params['phoneNumber'],
                'countryCode' => $params['countryCode']
            ];
            /** */
           $response = $reloadly->mobileNumberInformations(paramsData: $paramsData);
        }
        

        

        echo Responses::json([
            'status' => 'failed',
            'message' => "Something went wrong",
            'data' => $response,
        ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
        return;
    }

    /**data */
    public function airtime($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only POST method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        /**get the amount and the receiver phone number */
        $amount = isset($_POST['amount']) ? Security::kenProtectFunc($_POST['amount']) : '';
        $recipientPhone = isset($_POST['recipientPhone']) ? Security::kenProtectFunc($_POST['recipientPhone']) : '';
        $operatorId = isset($_POST['operatorId']) ? Security::kenProtectFunc($_POST['operatorId']) : '';
        $countryCode = isset($_POST['countryCode']) ? Security::kenProtectFunc($_POST['countryCode']) : '';
        /**check if the posted data are valid and not empty */
        if (empty($amount) || empty($recipientPhone) || empty($operatorId) || empty($countryCode)) {
            // User already logged in
            echo Responses::json([
                'status' => 'failed',
                'message' => 'All fields are required',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /*prepare the data to be posted */
        $postData = [
            "amount" => Security::removeSpaces($amount),
            "operatorId" => trim($operatorId),
            "number" => Security::formatMobile(mobile: $recipientPhone),
            "countryCode" => trim($countryCode)
        ];
        /**get operators by country */
        $response = $reloadly->buyAirtime(postData: $postData, isAutoDetectOperator: true);
        /**check if the request was successfull */
        if (!$response) {
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Some thing went wrong, please try again',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        /**check if the transaction was successfukl */
        if (isset($response) && !empty($response) && isset($response['transactionId'])) {
            /**make api call to check the status of the transactions */
            $transactionStatus = $reloadly->transactionStatus(transactionId: $response['transactionId']);
            /**return the response to the user */
            if (isset($transactionStatus) && !empty($transactionStatus)) {
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'Airtime recharge ' . strtolower($transactionStatus['status']),
                    'data' => [
                        'transactionId' => $response['transactionId'],
                        'amount' => $amount,
                        'phoneNumber' => $recipientPhone,
                    ]
                ], Env::SUCCESS_METHOD); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /**return the response to the user */
            if (isset($transactionStatus['message'])) {
                echo Responses::json([
                    'status' => 'failed',
                    'message' => $transactionStatus['message'],
                    'data' => []
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            echo Responses::json([
                'status' => 'failed',
                'message' => "Something went wrong",
                'data' => $transactionStatus,
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        /**return the response to the user */
        if (isset($response['message'])) {
            echo Responses::json([
                'status' => 'failed',
                'message' => $response['message'],
                'data' => [],
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        echo Responses::json([
            'status' => 'failed',
            'message' => "Something went wrong",
            'data' => $response,
        ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
        return;
    }

    /**get the transaction status */
    public function status($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /**get operators by country */
        if (isset($params) && $params != null) {
            $response =  $reloadly->transactionStatus(transactionId: $params['transactionId']);
            if (!empty($response) && isset($response['transaction'])) {
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'Transaction status retreived ',
                    'data' => $response['transaction']
                ], Env::SUCCESS_METHOD); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            // User already logged in
            echo Responses::json([
                'status' => 'failed',
                'message' => 'No transaction found for the transaction ID provided',
                'data' => $response
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        /**get all the transactions */
        $response =  $reloadly->transactionStatus();

        if (!empty($response) && isset($response['content'])) {
            echo Responses::json([
                'status' => 'success',
                'message' => 'Transaction status retreived ',
                'data' => $response['content']
            ], Env::SUCCESS_METHOD); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }
        /**return the universal error from the server */
        if ($response['message']) {
            echo Responses::json([
                'status' => 'failed',
                'message' => $response['message'],
                'data' => []
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        echo Responses::json([
            'status' => 'failed',
            'message' => 'Error completing request',
            'data' => $response
        ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
        return;
    }

    public function data($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            // Method not allowed
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Wrong request method, only GET method is supported for this endpoint',
            ], Env::NOT_ACCEPTABLE); // Assuming 405 is the code for METHOD_NOT_ALLOWED
            return;
        }
        /*user is not logged in */
        if (!Session::get('user')) {
            // User already logged in
            echo Responses::json([
                'status' => 'loggedout',
                'message' => 'Account not logged in, please login',
            ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            return;
        }

        /**create an object of the reloadly class */
        $reloadly = new ReloadlyVTUandGiftCard();
        /**get operators by country */
        if (isset($params) && $params != null) {
        }
    }

    public function balance($params = null)
    {
        $reloadly = new ReloadlyVTUandGiftCard();

        $reloadlyData =  $reloadly->accountBalance();
        echo json_encode($reloadlyData);
        return;
    }

    public function education($params = null)
    {
    }

    public function electricity($params = null)
    {
    }
}
