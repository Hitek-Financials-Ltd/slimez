<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class OtpRecordModel extends BaseModel
{
    protected $otpId;
    protected $userId;
    protected $type;
    protected $otpCode;

    protected $tableNames = ['otpRecord'];

    public function getOtpId()
    {
        return $this->otpId;
    }
    public function setOtpId($otpId): self
    {
        $this->otpId = $otpId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getOtpCode()
    {
        return $this->otpCode;
    }
    public function setOtpCode($otpCode): self
    {
        $this->otpCode = $otpCode;
        return $this;
    }

    public function selectQuery()
    {
        try {
            return BaseModel::query()->select($this->tableNames[0])
                ->where("otpId = ? || userId = ?", [$this->otpId, $this->userId])->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'otpId' => $this->otpId,
                'userId' => $this->userId,
                'type' => $this->type,
                'otpCode' => $this->otpCode,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        try {
            $updateData = array_filter([
                'userId' => $this->userId,
                'type' => $this->type,
                'otpCode' => $this->otpCode,
            ]);

            return BaseModel::query()->update($this->tableNames[0], $updateData)
                ->where("otpId = ? || userId = ?", [$this->otpId, $this->userId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                ->where("otpId = ? || userId = ?", [$this->otpId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
