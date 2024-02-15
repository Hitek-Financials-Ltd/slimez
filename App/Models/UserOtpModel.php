<?php

namespace Hitek\Slimez\App\Models;

use Hitek\Slimez\Core\BaseModel;

class UserOtpModel
{
    protected $otpId;
    protected $userId;
    protected $otp;
    protected $type;

    protected $tableNames = array('otpRecord');

    public function getOtpId()
    {
        return $this->otpId;
    }

    public function setOtpId($otpId)
    {
        $this->otpId = $otpId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getOtp()
    {
        return $this->otp;
    }

    public function setOtp($otp)
    {
        $this->otp = $otp;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    // select the user data
    public function selectQuery()
    {
        return BaseModel::query()
            ->select(tableName: $this->tableNames[0])
            ->where("otpId = ? || userId = ? || otp = ?", [$this->otpId, $this->userId, $this->otp])
            ->first();
    }

    // delete data
    public function deleteQuery()
    {
        $whereCondition = !empty($this->otpId) ? "otpId = ?" : (!empty($this->userId) ? "userId = ?" : null);
        $updateValue = !empty($this->otpId) ? $this->otpId : $this->userId;

        if ($whereCondition === null) {
            // Handle error: No identifier provided
            return false;
        }
        return BaseModel::query()
            ->delete(tableName: $this->tableNames[0])
            ->where($whereCondition, [$updateValue])
            ->save();
    }



    // update the users table 
    public function updateQuery()
    {
        $updateData = array_filter([
            "otp" => $this->otp,
            "type" => $this->type
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        $updateValue = !empty($this->otpId) ? $this->otpId : $this->userId;

        return BaseModel::query()
            ->update(tableName: $this->tableNames[0], dataValues: $updateData)
            ->where("otpId = ? || userId = ? || otp = ?", [$updateValue, $updateValue, $updateValue])
            ->save();
    }


    //    insert data to table
    public function insertQuery()
    {
        $dbTransactionData = [
            $this->tableNames,
            [
                ['otpId' => $this->otpId, 'userId' => $this->userId, 'otp' => $this->otp, 'type' => $this->type],
                // Include other related table data as needed
            ]
        ];

        return BaseModel::query()
            ->insertDbTransact(transactionData: $dbTransactionData)
            ->save();
    }
}
