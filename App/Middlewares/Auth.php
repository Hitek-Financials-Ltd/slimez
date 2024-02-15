<?php

/**
 * Author: Oaad Global
 * Developer: Hitek Financials Ltd
 * Year: 2024
 * Developer Contact: contact@tekfinancials.ng, kennethusiobaifo@yahoo.com
 * Project Name: Slimez
 * Description: Slimez.
 */

namespace Hitek\Slimez\App\Middlewares;

use Hitek\Slimez\Core\JwtAuth;
use Hitek\Slimez\Core\Redis;
use Hitek\Slimez\Configs\Env;
/**
 * Class Auth
 * Middleware class for authentication.
 */
class Auth
{
    /**
     * @var mixed The authentication payload.
     */
    protected static $authPayload;

    /**
     * Set the authentication token.
     *
     * @param string $key The key for the token.
     * @param array|string|null $payloadOrValue The payload or value for the token.
     * @param bool $isToken Indicates if the payload is a token.
     */
    public static function set(string $key = '', array|string $payloadOrValue = null, bool $isToken = false): void
    {
        // Generate and set the JWT token if the payload is an array and isToken is true
        if (!empty($payloadOrValue) && is_array($payloadOrValue) && $isToken == true) {
            $auth = JwtAuth::generateJWTToken($payloadOrValue);
            Redis::init()->setRedis(key: $key, value: $auth);
        }

        // Set the payload as a JSON string if the payload is an array and isToken is false
        if (!empty($payloadOrValue) && is_array($payloadOrValue) && $isToken == false) {
            Redis::init()->setRedis(key: $key, value: json_encode($payloadOrValue));
        }

        // Set a single value
        if (!empty($key) && is_string($payloadOrValue)) {
            Redis::init()->setRedis(key: $key, value: $payloadOrValue);
        }
    }

    /**
     * Get the token.
     *
     * @param string $key The key for the token.
     * @return mixed|null The token value or null if not found.
     */
    public static function get(string $key = '')
    {
        // Check if the token is set in the Redis storage
        if (!empty(Redis::init()->getRedis(trim($key)))) {
            // If the key is the JWT token key, return the token as is
            if (trim($key) == trim(Env::JWT_TOKEN_KEY_NAME)) {
                return Redis::init()->getRedis(trim($key));
            }
            // Return other tokens as an array
            return json_decode(Redis::init()->getRedis(trim($key)), true);
        } else {
            // If the token is not found in the Redis storage, return null
            return null;
        }
    }

    /**
     * Check if the user is authorized.
     *
     * @return bool Indicates if the user is authorized.
     */
    public static function isAuthorized()
    {
        // Check if the token from the user request header is valid
        if (JwtAuth::validateJWTToken(self::getBearerToken())) {
            return true;
        }
        return false;
    }

    /**
     * Logout the user.
     *
     * @param string $key The key for the token.
     * @return bool Indicates if the user was logged out successfully.
     */
    public static function exit(string $key = '')
    {
        if (!empty(self::get($key))) {
            if (!empty($key)) {
                Redis::init()->deleteRedis($key);
                
            }
            return true;
        }
        return false;
    }

    /**
     * Get the Authorization header.
     *
     * @return string|null The Authorization header value or null if not found.
     */
    public static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * Get the access token from the header.
     *
     * @return string The access token or an empty string if not found.
     */
    public static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return "";
    }
}
