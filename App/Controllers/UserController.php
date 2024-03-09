<?php

namespace Hitek\Slimez\App\Controllers;

use Hitek\Slimez\Core\BaseController;
use Hitek\Slimez\App\Models\UserModel;
use Hitek\Slimez\Configs\Env;
use Hitek\Slimez\Core\Responses;
use Hitek\Slimez\App\Middlewares\Auth;
use Hitek\Slimez\App\Models\DeletedAccountsModel;
use Hitek\Slimez\App\Models\OtpRecordModel;
use Hitek\Slimez\App\Models\UserMetaModel;
use Hitek\Slimez\App\Models\UserPersonalInfoModel;
use Hitek\Slimez\App\Models\UserVpnFilesModel;
use Hitek\Slimez\App\Models\VpnConfigsModel;
use Hitek\Slimez\App\Models\VpnSubscriptionModel;
use Hitek\Slimez\Core\AdvancedEmailSender;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Messaging;
use Hitek\Slimez\Core\Session;
use Hitek\Slimez\Core\FileUploader;
use Exception;
use Hitek\Slimez\Core\Cookie;

class UserController extends BaseController
{
    /**
     * @var user signup account
     */
    public function signup($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            if (Session::get('users')) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account logged in already',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**get post data */
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $password = isset($_POST['password']) ? Security::kenProtectFunc($_POST['password']) : '';
            $otp = isset($_POST['otp']) ? Security::kenProtectFunc($_POST['otp']) : '';
            /** check if email is correct*/

            if (!Security::emailRegularExpression($email)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email, please enter a valid email to proceed',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /** check if password is correct*/
            if (!Security::passwordRegularExpression($password)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong password pattern, should not be less than 6, contains uppercase characters, number and special characters',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**
             * create a user model object and setup the getters and setters
             *
             *
             * assign data to the setters of the UserModel class
             */

            $now = new \DateTime();
            $time = $now->format('Y-m-d H:i:s');

            $userIdGen = Security::genUuid();



            /**model */
            $userObj = new UserModel();



            $userObj->setUserId($userIdGen)
                ->setEmail(Security::kenProtectFunc($email))
                ->setTimestamp(Security::kenProtectFunc($time))
                ->setPassword(Security::kenProtectFunc($password))
                ->setOtpCode($otp);

            /**
             * select users from the table
             */
            $userData = $userObj->selectQuery();

            /**
             * check if the user is already in existence
             */

            if (!empty($userData)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User already exists, the email or phone number is already in use',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**create the account */
            $created = $userObj->insertQuery(true);

            /**
             * check if the account inserted successfully
             */
            if (!$created) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Error creating account, please try again',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**
             * select users from the table
             */
            $user = $userObj->selectQuery();
            /**set all the user model required in this model */

            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Oops! Something went wrong',
                    'data' => []
                ], Env::SERVER_ERROR_METHOD);
                return;
            }

            /**
             * send email notification
             */
            /**setting up email */
            $messageBody = "
            <div style='width: 100%; position: relative'>
              <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
              <h2 style='color: #000000; padding: 5px 0'>Hi " . ucfirst(explode("@", $email)[0]) . "</h2>
                 <p>You have successfully created an account with us at " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", please use the otp below to activate your account</p>
                 <p style='text-align: center; margin-top: 10px; padding: 10px'><strong style='font-size:40px,font-weight:bold;background-color: #f8f8f8; color: #000000 !important;padding: 5px 30px;'>" . $otp . " </strong></p>
                 
              </section>
              <br>
              <section style='width: 100%; position: relative; padding: 20px 0; text-align: center; '>
              <p>&copy; " . date('Y', time()) . " | " . Env::COMPANY_NAME . "</p>
              </section>
            </div>
            ";
            try {
                $emailSent = Messaging::sendEmail(
                    sender: Env::SMTP_USERNAME,
                    recipients: [$email],
                    message: $messageBody,
                    companyName: Env::COMPANY_NAME,
                    title: 'Account Created successfully',
                );
                /**return response to client */
                if ($emailSent) {
                    echo Responses::json([
                        'status' => 'success',
                        'message' => 'User was successfully created',
                        'data' => [],
                        'userId' => $userIdGen
                    ], Env::USER_CREATED);
                } else {
                    echo Responses::json([
                        'status' => 'success',
                        'message' => 'User was successfully created, email sending error, contact admin',
                        'data' => [],
                        'userId' => $userIdGen
                    ], Env::USER_CREATED);
                }
                return;
            } catch (Exception $e) {
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'User was successfully created with error sending email, contact customer service for help ',
                    'data' => []
                ], Env::USER_CREATED);
                return;
            }
        }
        /**
         * return the response error for the request method
         */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong request method, only POST method is supported for this endpoint',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    /**
     * @var user verify account
     */

    public function verifyAccount()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /**check if the user is already logged in and then log him out */
            if (Session::get('user')) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account logged in already',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**get post data */
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $otp = isset($_POST['otp']) ? Security::kenProtectFunc($_POST['otp']) : '';
            /** check if email is correct*/

            if (empty($email) || empty($otp)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'You cannot submit an empty form',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            if (!Security::emailRegularExpression($email)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email address',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            $userObj = new UserModel();

            /**update the account */
            $updated = $userObj->setEmail($email)
                ->setStatus(1);

            $userQuery = $userObj->selectQuery();

            $getOtpObj = new OtpRecordModel();

            if(empty($userQuery)){
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User not found',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            
            $getOtpObj->setUserId($userQuery['userId']);

            $otpData =  $getOtpObj->selectQuery();

            /**check if the user was otp was found */
            if (empty($otpData)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Incorrect otp code, please check email to enter the correct otp or resend the otp',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            if (isset($userQuery) && $userQuery['status'] != 0) {
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account activated already',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**update otp */
            $userObj->updateQuery();
            /**
             * 
             */
            if ($updated) {
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'Account activated successfully',
                    'data' => []
                ], Env::SUCCESS_METHOD);
                return;
            }
            echo Responses::json([
                'status' => 'failed',
                'message' => 'Failed to activate account',
                'data' => []
            ], Env::NOT_ACCEPTABLE);
            return;
        }

        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only post method is allowed with {email and password} parameters',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }

    /**
     * @var user signin
     */
    public function signin($params = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /**check if the user is already logged in and then log him out */
            // Session::sessDelete('user');
            if (Session::get('user')) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account logged in already',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page, wrong Access token',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**get post data */
            $username = isset($_POST['username']) ? Security::kenProtectFunc($_POST['username']) : '';
            $password = isset($_POST['password']) ? Security::kenProtectFunc($_POST['password']) : '';

            $email = explode("@", $username);

            /** check if email and password is correct*/
            if (!is_numeric($username) && isset($email[1])) {
                if (!Security::emailRegularExpression($username)) {
                    /**return response to client */
                    echo Responses::json([
                        'status' => 'failed',
                        'message' => 'Wrong email, please enter a valid email to proceed',
                        'data' => []
                    ], Env::WRONG_INPUT_METHOD);
                    return;
                }
            }

            /** check if email and password is correct*/
            if (!is_numeric($username) && !isset($email[1])) {
                if (!Security::usernameRegularExpression($username)) {
                    /**return response to client */
                    echo Responses::json([
                        'status' => 'failed',
                        'message' => 'Wrong username, please enter a valid username to proceed',
                        'data' => []
                    ], Env::WRONG_INPUT_METHOD);
                    return;
                }
            }
            if (is_numeric($username) && strlen($username) < 11) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong number entered, please enter a valid number',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check password */
            if (!Security::passwordRegularExpression($password)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong password pattern, password must contain only letters, numbers and special characters',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            $userObj = new UserModel();
            

            /**set the user email and password*/

            $userObj->setEmail($username)
                ->setPassword($password);

            /**get the user details */
            $user = $userObj->selectQuery();
            /**check if the user already exist */
            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email or password',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check if the user has activated his account */
            if ($user['status'] == '5') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'You no longer own account with us as the user has deleted their account. To regain your account please contact our customer service',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the pasword is correct */
            if (!Security::verifyPassword($password, Security::insertForwardSlashed($user['password']))) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email or password',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check if the user has activated his account */
            if ($user['status'] <= '0') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'not_activated',
                    'message' => 'Account not activated, please check your inbox and spam folder to activate your account via the email sent to you',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the user account is on hold */
            if (isset($user['status']) && $user['status'] == '2') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account is on hold, please waith for 2 minutes and try again',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**check if the user is suspended */
            if ($user['status'] == '3') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account suspended, please contact support',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the user is blocked */
            if ($user['status'] == '4') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account blocked, please contact support',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**
             * 
             */
            $metaDataObj = new UserMetaModel();
            /** */
            $metaDataObj->setUserId($user['userId']);

            $userMetaData = $metaDataObj->selectQuery();

            if(isset($userMetaData['device']) && $userMetaData['device'] >= Env::NUMBER_OF_DEVICES_ALLOW_PER_USER){
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'You have reached the limit number of '.Env::NUMBER_OF_DEVICES_ALLOW_PER_USER.' devices login into your account, please logout from other device and try agin',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            if(!empty($userMetaData)){
                
                  $metaDataObj->setDevice((int)$userMetaData['device']+1)
            ->setIsOnline('online');
            }
            /**get the user details */
            $userData = $userObj->selectQuery();
            
            /** */
            $metaDataObj->updateQuery();
            /** */
            $userObj->setEmail(Security::decryption(Security::insertForwardSlashed($userData['email'])));
            /**decrypted email */
            $userData['email'] = (string)Security::decryption(Security::insertForwardSlashed($userData['email']));
            $userData['phone'] = (string)Security::decryption(Security::insertForwardSlashed($userData['phone']));
            $userData['username'] = (string)Security::decryption(Security::insertForwardSlashed($userData['username']));

            $userData['profileImage'] = (string)$userData['profileImage'];
            $userData['status'] = (string)$userData['status'];
            /**
             * remove password from the array
             */
            unset($userData['password']);

            /**
             * add the JWT token to the array 
             */
            $userData['token'] = Auth::getBearerToken();

            Session::set('user', json_encode($userData));
            /**login was successful */
            echo Responses::json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => $userData,
            ], Env::SUCCESS_METHOD);
            return;
        }
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only post method is allowed with {email and password} parameters',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }


    /**
     * user profile
     */

    public function profile($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }

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
            $userId = isset($_POST['userId']) ? Security::kenProtectFunc($_POST['userId']) : '';

            $sessionUser = json_decode(Session::get('user'),true);
            /**check if the email is equal the session email */
            if ($userId != $sessionUser['userId']) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Not permitted to access this account',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**
             * create objects of models
             */
            $userObj = new UserModel();
            $metaDataObj = new UserMetaModel();
            $personalObj = new UserPersonalInfoModel();
            $userVpnFilesObj = new UserVpnFilesModel();
            $vpnConfigsObj = new VpnConfigsModel();
            $vpnSubObj = new VpnSubscriptionModel();

            $userObj->setUserId(trim($userId));
            /**
             * 
             */
            $userData = $userObj->selectQuery();

            if ($userData['status'] != 1) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Error with fetching profile data, check account status',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**
             * set up the setters and getters
             */
            $metaDataObj->setUserId($userData['userId']);
            /*
            * 
            */
            $personalObj->setUserId($userData['userId']);
            /*
            * This 
            */
            $userVpnFilesObj->setUserId($userData['userId']);
            /*
            * 
            */
            $vpnSubObj->setUserId($userData['userId']);
            /*
            *
            */

            if (!empty($userVpnFilesObj)) {
                $vpnConfigsObj->setStatus(1);
                $vpnConfigs = $vpnConfigsObj->selectQuery(isAll: true);

                $userData['configs'] = $vpnConfigs;
            }

            $meta = $metaDataObj->selectQuery();
            /**
             * 
             */
            $vpnSub = $vpnSubObj->selectQuery();
            /**
             * 
             */
            $userVpnFiles = $userVpnFilesObj->selectQuery();
            /**
             * 
             */
            $personal = $personalObj->selectQuery();
            /**
             * unset the user id from the array
             */
            if (!empty($personal)) {
                unset($personal['userId']);
                $userData['personal_info'] = $personal;
            }
            if (!empty($userVpnFiles)) {
                unset($userData['userId']);
                $userData['vpn_files'] = $userVpnFiles;
            }
            if (!empty($vpnSub)) {
                unset($vpnSub['userId']);
                $userData['vpn_sub'] = $vpnSub;
            }
            if (!empty($meta)) {
                unset($meta['userId']);
                $userData['meta_data'] = $meta;
            }

            unset($userData['password']);

            $userData['email'] = (string)Security::decryption(Security::insertForwardSlashed($userData['email']));
            $userData['phone'] = (string)Security::decryption(Security::insertForwardSlashed($userData['phone']));
            $userData['username'] = (string)Security::decryption(Security::insertForwardSlashed($userData['username']));

            $userData['profileImage'] = (string)$userData['profileImage'];

            echo Responses::json($userData);
            return;
        }
        /**
         * return the response error for the request method
         */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong request method, only POST method is supported for this endpoint',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    /**
     * @var user signout
     */
    public function signout($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            // if (!Session::get('user')) {
            //     // User already logged in
            //     echo Responses::json([
            //         'status' => 'loggedout',
            //         'message' => 'Account not logged in, please login ',
            //     ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
            //     return;
            // }
            /**get post data */
            $userId = isset($_POST['userId']) ? Security::kenProtectFunc($_POST['userId']) : '';
            /** */
            $userSesion = Session::get('user');
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /** */
            if (isset($userSesion['userId']) && $userSesion['userId'] != $userId) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User unidentified',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /** */
            $metaDataObj = new UserMetaModel();
            /**
             * set logout
             */
            $metaDataObj
            ->setUserId(trim($userId));
            /**update online status */
            /** */
            $metaDevices = $metaDataObj->selectQuery();
            // **all the user devices is offline
            if(isset($metaDevices['device']) && (int)$metaDevices['device'] == 1){
                $metaDataObj->setIsOnline('offline')
                ->setDevice(0);
            }
            /**user device online reduced */
            if(isset($metaDevices['device']) && (int)$metaDevices['device'] > 1){
                $metaDataObj->setDevice($metaDevices['device']-1);
            }
            /**update the meta data */
            $metaDataObj->updateQuery();
            /**delete monnfy loginsession */
            Session::sessDelete("bearer_token");
            /**detsry the session */
            Session::destroy();
            /**response message */
            echo Responses::json([
                'status' => 'success',
                'message' => 'Logout successfully',
                'data' => [],
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }


    /**
     * resend otp
     */
    public function otpSender()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $otpType = isset($_POST['type']) ? Security::kenProtectFunc($_POST['type']) : '';
            $otpPost = isset($_POST['otp']) ? Security::kenProtectFunc($_POST['otp']) : '';
            $title = isset($_POST['title']) ? Security::kenProtectFunc($_POST['title']) : '';
            /** */
            $userSesion = Session::get('user');
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /** */
            if (isset($userSesion) && $userSesion['email'] != $email) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User unidentified',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**get user from database */
            $userObj = new UserModel();
            /**setters and getters */
            $userObj->setEmail($email);
            /**get user */
            $user = $userObj->selectQuery();
            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User unidentified',
                    'data' => []
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**get OTP */
            $otpDataObj = new OtpRecordModel();

            $otpDataObj->setUserId($user['userId']);


            $dbOtp = $otpDataObj->selectQuery();



            if (empty($dbOtp)) {
                /**return response to client */
                $otpDataObj->setOtpId(Security::genUuid())
                    ->setUserId($user['userId'])
                    ->setType($otpType)
                    ->setOtpCode($otpPost);

                $otpDataObj->insertQuery();
            } else {
                /**return response to client */
                $otpDataObj->setUserId($user['userId'])
                    ->setType($otpType)
                    ->setOtpCode($otpPost);
                /**update the row */
                $otpDataObj->updateQuery();
            }


            /**setting up email */
            $messageBody = "
            <div style='width: 100%; position: relative'>
              <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
              <h2 style='color: #000000; padding: 5px 0'>Hi " . ucfirst(explode("@", Security::decryption(Security::insertForwardSlashed($user['email'])))[0]) . "</h2>
                 <p>You requested a ".$otpType." OTP code from " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", below is the otp code</p>
                 <p style='text-align: center; margin-top: 10px; padding: 10px'><strong style='font-size:80px,font-weight:bold;background-color: #f8f8f8; color: #000000 !important;padding: 5px 30px;'>" . $otpPost . " </strong></p>
                 <p>Please ignore this email if you are not the one that requested this code</p>
                 
              </section>
              <br>
              <section style='width: 100%; position: relative; padding: 20px 0; text-align: center; '>
              <p>&copy; " . date('Y', time()) . " | " . Env::COMPANY_NAME . "</p>
              </section>
            </div>
            ";
            /**send email */
            $emailing = Messaging::sendEmail(
                sender: Env::SMTP_USERNAME,
                companyName: Env::COMPANY_NAME,
                recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                message: $messageBody,
                title: $title
            );

            if (!$emailing) {
                /**response message */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Error Sending OTP',
                    'data' => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            /**response message */
            echo Responses::json([
                'status' => 'success',
                'message' => 'OTP sent successfully',
                'data' => []
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }

    /** 
     * @var user change password
     */
    public function changePassword()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**get post data */
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $newPassword = isset($_POST['newPassword']) ? Security::kenProtectFunc($_POST['newPassword']) : '';
            $otp = isset($_POST['otp']) ? Security::kenProtectFunc($_POST['otp']) : '';
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**get user from database */
            $userDataOBj = new UserModel();
            /**setters and getters */
            $userDataOBj->setEmail(trim($email));
            /**seletc the user */
            $user = $userDataOBj->selectQuery();
            /**check if there is user found */
            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User not found',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**otp model */
            $otpDataObj = new OtpRecordModel();

            $otpDataObj->setUserId($user['userId']);


            $dbOtp = $otpDataObj->selectQuery();

            if (empty($dbOtp)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            if ($dbOtp['otpCode'] != $otp) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong OTP Code',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }


            /**setters and getters */
            $userDataOBj->setUserId($user['userId'])
                ->setPassword($newPassword);
            /**update */
            if (!$userDataOBj->updateQuery()) {
                /**response message */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Password changed failed',
                    'data' => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            /**setting up email */
            $messageBody = "
                 <div style='width: 100%; position: relative'>
                   <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
                   <h2 style='color: #000000; padding: 5px 0'>Hi " . ucfirst(explode("@", Security::decryption(Security::insertForwardSlashed($user['email'])))[0]) . "</h2>
                      <p>You have successfully changed your password at " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", if this is not you, please contact our support service at <contact@kvpnsmart.com> as fast as possible</p>
                      <p style='text-align: center; margin-top: 10px; padding: 10px'></p>
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
                recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                message: $messageBody,
                title: 'Password changed successfully'
            );
            /**update online status */
            /** */
            Session::sessDelete('user');
            /**response message */
            echo Responses::json([
                'status' => 'success',
                'message' => 'Password changed successfully',
                'data' => []
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }

    /**
     * @var user request password change
     */
    public function resetPassword()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            $email = isset($_POST['email']) ? Security::kenProtectFunc($_POST['email']) : '';
            $otpPost = isset($_POST['otp']) ? Security::kenProtectFunc($_POST['otp']) : '';
            /** */
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**get user from database */
            $userObj = new UserModel();
            /**setters and getters */
            $userObj->setEmail($email);
            /**get user */
            $user = $userObj->selectQuery();
            /**get OTP */
            $otpDataObj = new OtpRecordModel();

            $otpDataObj->setUserId($user['userId']);


            $dbOtp = $otpDataObj->selectQuery();

            if (empty($dbOtp)) {
                /**return response to client */
                $otpDataObj->setOtpId(Security::genUuid())
                    ->setUserId($user['userId'])
                    ->setType('reset_password')
                    ->setOtpCode($otpPost);

                $otpDataObj->insertQuery();
            } else {
                /**return response to client */
                $otpDataObj->setUserId($user['userId'])
                    ->setType('reset_password')
                    ->setOtpCode($otpPost);
                /**update the row */
                $otpDataObj->updateQuery();
            }



            /**setting up email */
            $messageBody = "
                 <div style='width: 100%; position: relative'>
                   <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
                   <h2 style='color: #000000; padding: 5px 0'>Hi " . ucfirst(explode("@", Security::decryption(Security::insertForwardSlashed($user['email'])))[0]) . "</h2>
                      <p>You have requested a password reset at " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", if this wasn't you please ignore this message, otherwise use the below otp to proceed</p>
                      <p style='text-align: center; margin-top: 10px; padding: 10px'><strong style='font-size:40px,font-weight:bold;background-color: #f8f8f8; color: #000000 !important;padding: 5px 30px;'>" . $otpPost . " </strong></p>
                      
                   </section>
                   <br>
                   <section style='width: 100%; position: relative; padding: 20px 0; text-align: center; '>
                   <p>&copy; " . date('Y', time()) . " | " . Env::COMPANY_NAME . "</p>
                   </section>
                 </div>
                 ";

            /**send email */
            $emailing = Messaging::sendEmail(
                sender: Env::SMTP_USERNAME,
                companyName: Env::COMPANY_NAME,
                recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                message: $messageBody,
                title: "Password reset"
            );

            if (!$emailing) {
                /**response message */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Error Sending OTP',
                    'data' => []
                ], Env::NOT_ACCEPTABLE);
                return;
            }

            /**response message */
            echo Responses::json([
                'status' => 'success',
                'message' => 'OTP sent successfully, please check your email',
                'data' => []
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }

    /**
     * @var user delete account
     */
    public function deleteAccount()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            
            /**check if the user is already logged in and then log him out */
            $userId = isset($_POST['userId']) ? Security::kenProtectFunc($_POST['userId']) : '';
            $reason = isset($_POST['reason']) ? Security::kenProtectFunc($_POST['reason']) : '';
            /** */
           
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**get user from database */
            $userObj = new UserModel();
            /**setters and getters */
            $userObj->setUserId(trim($userId));
            /**get user */
            $user = $userObj->selectQuery();
            /**check user */
            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to perform this operation',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**delete the account */



            $metaDataObj = new UserMetaModel();
            $metaDataObj->setUserId(trim($userId));
            $metaDataObj->deleteQuery();

            $personalObj = new UserPersonalInfoModel();
            $personalObj->setUserId(trim($userId));
            $personalObj->deleteQuery();

            $vpnSubObj = new VpnSubscriptionModel();
            $vpnSubObj->setUserId(trim($userId));
            $vpnSubObj->deleteQuery();

            $otpDataObj = new OtpRecordModel();
            $otpDataObj->setUserId(trim($userId));
            $otpDataObj->deleteQuery();

            $userObj = new UserModel();
            $userObj->setUserId(trim($userId));
            $userObj->deleteQuery(isSoftDelete: false);

            $dateDeleted = new \DateTime();
            $datetime = $dateDeleted->format('Y-m-d H:i:s');


            /**insert the deleted reason to database */
            $deletedAccountObj = new DeletedAccountsModel();
            $deletedAccountObj->setDeleteId(Security::genUuid())
                ->setEmail($user['email'])
                ->setReason($reason)
                ->setDateDeleted($datetime);

            $deletedAccountObj->insertQuery();

            Session::destroy();


            /**setting up email */

            $messageBody = "
                 <div style='width: 100%; position: relative'>
                   <section style='width: 100%; background-color: #ffffff; padding: 20px; position: relative'>
                   <h2 style='color: #000000; padding: 5px 0'>Hi " . ucfirst(explode("@", Security::decryption(Security::insertForwardSlashed($user['email'])))[0]) . "</h2>
                      <p>Your account with " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", was deleted successfully, we hope to see you back soon</p> 
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
                recipients: [Security::decryption(Security::insertForwardSlashed($user['email']))],
                message: $messageBody,
                title: "Account Deleted"
            );

            /**response message */
            echo Responses::json([
                'status' => 'success',
                'message' => 'Account was deleted successfully',
                'data' => []
            ], Env::SUCCESS_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }

    /**
     * @var user update account
     */
    public function updateAccount()
    {

        echo "Welcome update account";
    }

    /**
     * @var upload file
     */
    public function uploadFile()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            if (!Session::get('user')) {
                // User already logged in
                echo Responses::json([
                    'status' => 'loggedout',
                    'message' => 'Account not logged in, please login',
                ], Env::NOT_ACCEPTABLE); // Assuming 400 is the code for WRONG_INPUT_METHOD
                return;
            }
            /**check if the user is already logged in and then log him out */
            $userId = isset($_POST['userId']) ? Security::kenProtectFunc($_POST['userId']) : '';
            $FILES = isset($_FILES['postfile']) ? $_FILES['postfile'] : '';
            /** */
            /** */
            if (Auth::getBearerToken() != Env::API_TOKEN) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Forbidden to access this page',
                    'data' => []
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            $uploaded = FileUploader::uploadFile($userId, $FILES);

            echo json_encode($uploaded);

            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only POST method is allowed',
            'data' => []
        ], Env::METHOD_NOT_ALLOWED);
    }
}
