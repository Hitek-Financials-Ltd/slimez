<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class VirtualAccountModel extends BaseModel
{
    protected $virtualId;
    protected $userId;
    protected $gatewayProvider;
    protected $accountNumber;
    protected $accountName;
    protected $bankName;
    protected $accountReference;
    protected $status;
    protected $createdAt;

    protected $tableNames = ['virtual_accounts'];

    public function getVirtualId()
    {
        return $this->virtualId;
    }

    public function setVirtualId($virtualId): self
    {
        $this->virtualId = $virtualId;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    // CRUD methods for virtual_accounts table

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("userId = ? || accountReference = ?", [$this->userId, $this->accountReference])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("userId = ? || accountReference = ?", [$this->userId, $this->accountReference])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'virtualId' => $this->virtualId,
                'userId' => $this->userId,
                'gatewayProvider' => $this->gatewayProvider,
                'accountNumber' => $this->accountNumber,
                'accountName' => $this->accountName,
                'bankName' => $this->bankName,
                'accountReference' => $this->accountReference,
                'status' => $this->status,
                'createdAt' => $this->createdAt,
            ]);

            return BaseModel::query()->insert($this->tableNames[0], $insertData)->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function updateQuery()
    {
        $updateData = array_filter([
            'gatewayProvider' => $this->gatewayProvider,
            'accountNumber' => $this->accountNumber,
            'accountName' => $this->accountName,
            'bankName' => $this->bankName,
            'status' => $this->status,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("virtualId = ? || userId = ? || accountReference = ?", [$this->virtualId, $this->userId, $this->accountReference])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                ->where("virtualId = ? || userId = ? || accountReference = ?", [$this->virtualId, $this->userId, $this->accountReference])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
