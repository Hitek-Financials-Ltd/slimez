<?php


namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Security;
use Hitek\Slimez\Core\Exceptions;

class UserModel extends BaseModel
{
    protected $userId;
    protected $username;
    protected $email;
    protected $password;
    protected $phone;
    protected $status;
    protected $profileImage;
    protected $timestamp;
    protected $otpCode;

    protected $tableNames = array('users','user_meta','user_personal_info','vpn_subscription','otpRecord');

    // Assuming other necessary properties and methods exist...

    // Getters and Setters

    public function getUserId()
    {
        return $this->userId;
    }

    public function setOtpCode($otpCode)
    {
        $this->otpCode = $otpCode;
        return $this;
    }

    public function getOtpCode()
    {
        return $this->otpCode;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getProfileImage()
    {
        return $this->profileImage;
    }

    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
        return $this;
    }


    public function getUsername()
    {
        return Security::decryption(Security::insertForwardSlashed($this->username));
    }

    public function setUsername($username)
    {
        $this->username = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($username)));
        return $this;
    }

    public function getEmail()
    {
        return Security::decryption(Security::insertForwardSlashed($this->email));
    }

    public function setEmail($email)
    {
        $this->email = Security::replaceForwardSlashed(Security::encryption(Security::removeSpaces($email)));
        return $this;
    }

    public function getPassword()
    {
        return Security::insertForwardSlashed($this->password);
    }

    public function setPassword($password)
    {
        $this->password = Security::replaceForwardSlashed(Security::hashPassword($password));
        return $this;
    }

    public function getPhone()
    {
        return Security::decryption(Security::insertForwardSlashed($this->phone));
    }

    public function setPhone($phone)
    {
        $this->phone = Security::replaceForwardSlashed(Security::encryption(Security::formatMobile($phone)));
        return $this;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    // select the user data
    public function selectQuery()
    {
        try {
            return BaseModel::query()
                ->select(tableName: $this->tableNames[0])
                ->where("userId = ? || email = ? || phone = ? || username = ?", [$this->userId, $this->email, $this->phone, $this->username])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // delete data
    public function deleteQuery(bool $isSoftDelete = true)
    {
        try {
            if ($isSoftDelete) {
                return BaseModel::query()
                    ->update(tableName: $this->tableNames[0], dataValues: ["status" => 5])
                    ->where("userId = ? || email = ?", [$this->userId, $this->email])
                    ->save();
            } else {
                return BaseModel::query()
                    ->delete(tableName: $this->tableNames[0])
                    ->where("userId = ? || email = ?", [$this->userId, $this->email])
                    ->save();
            }
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    // update the users table 
    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                "phone" => $this->phone,
                "password" => $this->password,
                "username" => $this->username,
                "profileImage"=> $this->profileImage,
                "status"=> $this->status,
                "timestamp" => $this->timestamp
            ]);

            if (empty($updateData)) {
                return false; // No data to update
            }

            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("userId = ? || email = ?", [$this->userId, $this->email])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }


    //    insert data to table
    public function insertQuery($isTransaction = false)
    {

        $userData = array_filter(['userId' => $this->userId, 'email' => $this->email, 'password' => $this->password]);
        $insertMetaData = array_filter(['metaId' => Security::genUuid(), 'userId' => $this->userId]);
        $insertPersonalInfo = array_filter(['pInfoId' => Security::genUuid(),'userId' => $this->userId]);
        $vpnsubscription = array_filter(['subId' => Security::genUuid(),'userId' => $this->userId]);
        $otpCode = array_filter(['otpId' => Security::genUuid(),'userId' => $this->userId, 'type'=>'register', 'otpCode' => $this->otpCode]);

        try {
            /**
             * transaction insert
             */
            if ($isTransaction) {
                $tranData = [
                    /**tables */
                     $this->tableNames,
                     [
                        $userData,
                        /**first table data */
                        $insertMetaData,
                        /**second table data */
                        $insertPersonalInfo,
                        /** */
                        $vpnsubscription,
                        /** */
                        $otpCode
                    ],
                ];
                return BaseModel::query()->insertDbTransact($tranData)->save();
            }

            return BaseModel::query()
                ->insert(tableName: $this->tableNames[0], query: $userData)
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
