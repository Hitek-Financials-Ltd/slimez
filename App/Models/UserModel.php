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
    // wallet
    protected $walletId;
    protected $ledgerBalance;
    protected $walletBalance;
    protected $updatedAt;
    protected $createdAt;

    protected $virtualId;
    protected $gatewayProvider;
    protected $accountNumber;
    protected $accountName;
    protected $bankName;
    protected $accountReference;

    protected $tableNames = array('users','user_meta','user_personal_info','vpn_subscription','otpRecord','wallet', 'virtual_accounts');

    // Assuming other necessary properties and methods exist...

    public function getWalletId()
    {
        return $this->walletId;
    }

    public function setWalletId($walletId)
    {
        $this->walletId = $walletId;
        return $this;
    }

    public function getLedgerBalance()
    {
        return $this->ledgerBalance;
    }

    public function setLedgerBalance($ledgerBalance)
    {
        $this->ledgerBalance = $ledgerBalance;
        return $this;
    }

    public function getWalletBalance()
    {
        return $this->walletBalance;
    }

    public function setWalletBalance($walletBalance)
    {
        $this->walletBalance = $walletBalance;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    
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


    public function getVirtualId()
    {
        return $this->virtualId;
    }

    public function setVirtualId($virtualId): self
    {
        $this->virtualId = $virtualId;
        return $this;
    }
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getGatewayProvider()
    {
        return $this->gatewayProvider;
    }

    public function setGatewayProvider($gatewayProvider): self
    {
        $this->gatewayProvider = $gatewayProvider;
        return $this;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setAccountNumber($accountNumber): self
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function getAccountName()
    {
        return $this->accountName;
    }

    public function setAccountName($accountName): self
    {
        $this->accountName = $accountName;
        return $this;
    }

    public function getBankName()
    {
        return $this->bankName;
    }

    public function setBankName($bankName): self
    {
        $this->bankName = $bankName;
        return $this;
    }

    public function getAccountReference()
    {
        return $this->accountReference;
    }

    public function setAccountReference($accountReference): self
    {
        $this->accountReference = $accountReference;
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

        $userData = array_filter([
            'userId' => $this->userId, 
            'email' => $this->email, 
            'password' => $this->password
        ]);
        $insertMetaData = array_filter([
            'metaId' => Security::genUuid(), 
            'userId' => $this->userId
        ]);
        $insertPersonalInfo = array_filter([
            'pInfoId' => Security::genUuid(),
            'userId' => $this->userId
        ]);
        $vpnsubscription = array_filter([
            'subId' => Security::genUuid(),
            'userId' => $this->userId
        ]);
        $otpCode = array_filter([
            'otpId' => Security::genUuid(),
            'userId' => $this->userId, 
            'type'=>'register', 
            'otpCode' => $this->otpCode
        ]);
        $walletData = array_filter([
            'walletId' => Security::genUuid(),
            'userId' => $this->userId,
            'ledger_balance' => $this->ledgerBalance,
            'wallet_balance' => $this->walletBalance
        ]);

        $virtualAccount = array_filter([
            'virtualId' => Security::genUuid(),
            'userId' => $this->userId,
            'gatewayProvider' => $this->gatewayProvider,
            'accountNumber' => $this->accountNumber,
            'accountName' => $this->accountName,
            'bankName' => $this->bankName,
            'accountReference' => $this->accountReference,
        ]);

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
                        $otpCode,
                        /**the wallet */
                        $walletData,
                        // virtual account
                        $virtualAccount
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
