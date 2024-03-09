<?php

namespace Hitek\Slimez\App\Controllers;

use Hitek\Slimez\App\Models\ServerSettingsModel;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\Core\MonnifyPayment;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\SeerbitPayment;
use Hitek\Slimez\Core\Session;
use Hitek\Slimez\Core\WebhookSampleData;

class PaymentsController extends BaseController{
    // payment webhook
    public function webhook($param = null){
        $monnifyData = json_decode(WebhookSampleData::$monnifyCardTransactionCompleted, true);

        echo json_encode($monnifyData['eventData']['transactionReference']);
        return;
    }


    public function getPayment($param = null){

        // if (!Session::get('user')) {
        //         // User already logged in
        //         echo Responses::json([
        //             'status' => 'loggedout',
        //             'message' => 'Account not logged in, please login ',
        //         ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
        //         return;
        //     }
        /**check the payment gateway activated */

       $gateWayObj = new ServerSettingsModel();

       $gateWayData = $gateWayObj
                    ->setSettingsId("1")
                    ->selectQuery();

        if(!isset($gateWayData['paymentGateWay'])){
            echo Responses::json([
                'status' => "failed",
                'messages' => "Choose a payment gateway to be used for this transaction",
                'data' => []
            ]);
            return;
        }

        // use a switch statement to determin the gateways to use
        switch ($gateWayData['paymentGateWay']) {
            case 1:
                /**processe paystack payment gateway */

                break;
            case 2:
                /**processe monnify payment gateway */
                $monnify = new MonnifyPayment();

                // $payload = [
                //       "amount" => 100.00,
                //       "customerName" => "Stephen Ikhane",
                //       "customerEmail" => "stephen@ikhane.com",
                //       "paymentDescription" => "Trial transaction",
                //       "currencyCode" => "NGN",
                //       "paymentMethods" => ["CARD","ACCOUNT_TRANSFER"]
                // ];

                // $postParams =  [
                //     'amount' => 100.0,
                //     'narration' => "Paying for sub",
                //     'destinationBankCode' => "",
                //     'destinationAccountNumber' => "",
                //     'currency' => "NGN",
                //     'sourceAccountNumber' => "",
                //     'destinationAccountName' => "",
                // ];

            //    $response =  $monnify->reserveVirtualAccount(
            //         reference: "HITEK".(string)Security::OTPGen(length: 8)."SMT",
            //         customerFullName: "Omoragbon Faith",
            //         customerEmail: "faith@bcods.com",
            //         bvn: "08140144857"
            //     );


            // $mon = $monnify->initializeTransaction(
            //     amount: 100.0,
            //     customerName: "Usiobaifo Kenneth",
            //     customerEmail: "kenneth@yahoo.com",
            //     narration: "Monthly subscription",
            //     currencyCode: "NGN"
            // );



                echo json_decode("etuwyeutweyu");

                return;


                break;
            
            case 3:
                /**processe seerbit payment gateway */
                $seerbitPayment = new SeerbitPayment();

                echo json_encode($seerbitPayment->bearerToken());
                return;

                break;
            
            case 4:
                /**processe lenco payment gateway */

                break;

            case 5:
                /**processe paypay payment gateway */

                break;
            
            default:
                /**processe flutterwave payment gateway */


                break;
        }


       echo json_encode($gateWayData);

       return;



    }




}