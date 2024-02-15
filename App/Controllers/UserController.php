<?php

namespace Hitek\OaadGlobal\App\Controllers;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

use Hitek\OaadGlobal\Core\BaseController;
use Hitek\OaadGlobal\App\Models\UserModel;
use Hitek\OaadGlobal\App\Models\UserOtpModel;
use Hitek\OaadGlobal\Configs\Env;
use Hitek\OaadGlobal\Core\Responses;
use Hitek\OaadGlobal\App\Middlewares\Auth;
use Hitek\OaadGlobal\App\Models\MembersModel;
use Hitek\OaadGlobal\App\Models\UsersAddressModel;
use Hitek\OaadGlobal\App\Models\UsersEmailModel;
use Hitek\OaadGlobal\App\Models\UsersMetadataModel;
use Hitek\OaadGlobal\App\Models\UsersPhoneNumbersModel;
use Hitek\OaadGlobal\App\Models\UsersResearchInfoModel;
use Hitek\OaadGlobal\Core\Security;
use Hitek\OaadGlobal\Core\Messaging;
use Hitek\OaadGlobal\Core\Redis;
use Hitek\OaadGlobal\Core\Session;
use Hitek\OaadGlobal\Core\Twilio;

class UserController extends BaseController
{



    protected UserModel $userObj;
    

    public function __construct()
    {
        $this->userObj = new UserModel();
    }

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
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /** check if password is correct*/
            if (!Security::passwordRegularExpression($password)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong password pattern, should not be less than 6, contains uppercase characters, number and special characters',
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



            $this->userObj->setUserId($userIdGen)
                ->setEmail(Security::kenProtectFunc($email))
                ->setTimestamp(Security::kenProtectFunc($time))
                ->setPassword(Security::kenProtectFunc($password));

            /**
             * select users from the table
             */
            $userData = $this->userObj->selectQuery();
           
            /**
             * check if the user is already in existence
             */

            if (!empty($userData)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'User already exists, the email or phone number is already in use',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }


            /**create the account */
            $created = $this->userObj->insertQuery();
            /**
             * check if the account inserted successfully
             */
            if (!$created) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Error creating account, please try again',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }
            /**
             * select users from the table
             */
            $user = $this->userObj->selectQuery();
            /**set all the user model required in this model */

            $otpObj = new UserOtpModel() ;
            $userAddr = new UsersAddressModel();
            $userMeta = new UsersMetadataModel();
            $userEmail = new UsersEmailModel();
            $userPhone = new UsersPhoneNumbersModel();
            $userResearchInfo = new UsersResearchInfoModel();
            $memberModel = new MembersModel();


            /**prepare the setters and getters for the model classes */
            $userAddr->setAddressId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();

            $userMeta->setMetadataId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();

            $userEmail->setUsersEmailId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();
            
            $userPhone->setUsersPhoneId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();

            $userResearchInfo->setUsersResearchId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();

            $memberModel->setMemId(Security::genUuid())
                      ->setUserId($userIdGen)
                      ->setStatus(1)
                      ->insertQuery();

            $otpObj->setOtpId(Security::genUuid())
                    ->setUserId($userIdGen)
                    ->setOtp($otp)
                    ->setType("register")
                    ->insertQuery();

                    echo Responses::json($user);
                    return;

            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Oops! Something went wrong',
                ], Env::SERVER_ERROR_METHOD);
                return;
            }

            /**
             * send email notification
             */
            /**setting up email */
            $messageBody = "
                 <h3>Hi " . ucfirst(Security::decryption(explode("@", $user['emailAddress'])[0])) . "</h3>
                 <p>You have successfully created an account with us at " . ucfirst(strtolower(Env::SYSTEM_NAME)) . ", please use the otp below to activate your account</p>
                 <p style='text-align: center; margin-top: 10px; padding: 10px'><strong style='font-size:30px,font-weight:bold;background-color: #f1f1f1;'>" . $otp . " </strong></p>
                 ";

            $emailSent = Messaging::phpMailerEmail(
                userEmail: $email,
                senderEmail: Env::EMAIL_HOST_USER,
                companyName: Env::SYSTEM_NAME,
                title: 'Account Created successfully',
                messageData: $messageBody
            );

            // $transport = Transport::fromDsn('smtp://contact@bcods.com:Etiosa11//@smtp.bcods.com:587'); // Replace with your SMTP credentials
            // $mailer = new Mailer($transport);

            // $emailSent = Messaging::syfonEmail(
            //     $mailer, 
            //     Env::EMAIL_HOST_USER, 
            //     $email, 
            //     $messageBody , 
            //     'Account Created successfully'
            // );

            /**check if the email was sent */
            if ($emailSent) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'User was successfully created',
                ], Env::USER_CREATED);
                return;
            }

            echo Responses::json([
                'status' => 'success',
                'message' => 'User was successfully created with error sending email, contact customer service for help',
            ], Env::USER_CREATED);
            return;
        }
        /**
         * return the response error for the request method
         */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong request method, only POST method is supported for this endpoint',
        ], Env::METHOD_NOT_ALLOWED);
        return;
    }

    /**
     * @var user signin
     */
    public function signin($params = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the user is already logged in and then log him out */
            Auth::exit(Env::JWT_TOKEN_KEY_NAME);
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
                    ], Env::WRONG_INPUT_METHOD);
                    return;
                }
            }
            if (is_numeric($username) && strlen($username) < 11) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong number entered, please enter a valid number',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check password */
            if (!Security::passwordRegularExpression($password)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong password pattern, password must contain only letters, numbers and special characters',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**set the user email and password*/

            $this->userObj->setEmail($username)
                ->setPhone($username)
                ->setUsername($username)
                ->setPassword($password);

            /**get the user details */
            $user = $this->userObj->selectQuery();

            /**check if the user already exist */
            if (empty($user)) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email or password',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check if the user has activated his account */
            if ($user['status'] == '5') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'You no longer own account with us as the user has deleted their account. To regain your account please contact our customer service',
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the pasword is correct */
            if (!Security::verifyPassword($password, Security::insertForwardSlashed($user['password']))) {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Wrong email or password',
                ], Env::WRONG_INPUT_METHOD);
                return;
            }

            /**check if the user has activated his account */
            if ($user['status'] <= '0') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account not activated, please check your inbox and spam folder to activate your account via the email sent to you',
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the user account is on hold */
            if (isset($user['status']) && $user['status'] == '2') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account is on hold, please waith for 2 minutes and try again',
                ], Env::FORBIDDEN_METHOD);
                return;
            }
            /**check if the user is suspended */
            if ($user['status'] == '3') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account suspended, please contact support',
                ], Env::FORBIDDEN_METHOD);
                return;
            }

            /**check if the user is blocked */
            if ($user['status'] == '4') {
                /**return response to client */
                echo Responses::json([
                    'status' => 'failed',
                    'message' => 'Account blocked, please contact support',
                ], Env::FORBIDDEN_METHOD);
                return;
            }


            /**get the user details */
            $userData = $this->userObj->selectQuery();

            $this->userObj->setEmail(Security::decryption(Security::insertForwardSlashed($userData['emailAddress'])));

            /**update online status */
            $this->userObj->updateQuery();

            /**new timestamp */
            $userData['timestamp'] = time();
            /**decrypted email */
            $userData['emailAddress'] = (string)Security::decryption(Security::insertForwardSlashed($userData['emailAddress']));

            /**decrypted username */
            $userData['username'] = (string)Security::decryption(Security::insertForwardSlashed($userData['username']));
            /**decrypted phone */
            $userData['phone'] = (string)Security::decryption(Security::insertForwardSlashed($userData['phone']));


            $userData['firstName'] = (string)Security::decryption(Security::insertForwardSlashed($userData['firstName']));


            $userData['lastName'] = (string)Security::decryption(Security::insertForwardSlashed($userData['lastName']));
            $userData['profileImage'] = (string)Security::decryption(Security::insertForwardSlashed($userData['profileImage']));
            $userData['isOnline'] = "online";
            /**
             * remove password from the array
             */
            unset($userData['password']);

            $tokenPayload = [
                'email' => $userData['emailAddress'],
                'phoneNumber' => $userData['phone'],
                'userId' => $userData['userId'],
            ];


            /**set the JWT token */
            Auth::set(key: Env::JWT_TOKEN_KEY_NAME, payloadOrValue: $tokenPayload, isToken: true);

            /**
             * add the JWT token to the array 
             */
            $userData['token'] = Auth::get(Env::JWT_TOKEN_KEY_NAME);

            Auth::set(key: 'user', payloadOrValue: json_encode($userData));
            /**login was successful */
            echo Responses::json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => Auth::get("user"),
            ], Env::SUCCESS_METHOD);
            return;
        }
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only post method is allowed with {email and password} parameters',

        ], Env::METHOD_NOT_ALLOWED);
    }


    /**
     * user profile
     */

    public function profile()
    {
        echo "Welcome to the profile ";
    }

    /**
     * @var user signout
     */
    public function signout($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**check if the token is set */
            if (Auth::isAuthorized()) {
                /**
                 * get the user data from Redis storage
                 */
                $user = Auth::get('user');

                /**
                 * set logout
                 */
                $this->userObj->setEmail(Security::decryption(Security::insertForwardSlashed($user['emailAddress'])))
                    ->setPhone(Security::decryption(Security::insertForwardSlashed($user['phone'])))
                    ->setUserId($user['userId']);
                /**destroy the user session */
                Auth::exit(Env::JWT_TOKEN_KEY_NAME);
                Auth::exit('user');
                /**update online status */
                $this->userObj->updateQuery();
                /**response message */
                echo Responses::json([
                    'status' => 'success',
                    'message' => 'Logout successfully',

                ], Env::SUCCESS_METHOD);
                return;
            }
            /**response message */
            echo Responses::json([
                'status' => 'failed',
                'message' => 'You are not logged in, please login',
            ], Env::FORBIDDEN_METHOD);
            return;
        }
        /**response message */
        echo Responses::json([
            'status' => 'failed',
            'message' => 'Wrong resquest method, only GET method is allowed',

        ], Env::METHOD_NOT_ALLOWED);
    }

    /**
     * @var user verify account
     */

    public function verifyAccount()
    {

        echo "Welcome Verify account";
    }
    /**
     * resend otp
     */
    public function otp()
    {
        echo "Welcome otp";
    }

    /** 
     * @var user change password
     */
    public function changePassword()
    {

        echo "Welcome change password";
    }

    /**
     * @var user request password change
     */
    public function resetPassword()
    {

        echo "Welcome request password change";
    }

    /**
     * @var user delete account
     */
    public function deleteAccount()
    {

        echo "Welcome delete account";
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

        echo "Welcome upload file";
    }
    /**
     * @var address
     */
    public function address()
    {
        echo "Welcome address";
    }
}
