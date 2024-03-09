<?php

namespace Hitek\Slimez\App\Models;

use Exception;
use Hitek\Slimez\Core\BaseModel;
use Hitek\Slimez\Core\Exceptions;

class WalletModel extends BaseModel
{
    protected $walletId;
    protected $userId;
    protected $ledgerBalance;
    protected $walletBalance;
    protected $status;
    protected $updatedAt;
    protected $createdAt;

    protected $tableNames = ['wallet'];

    public function getWalletId()
    {
        return $this->walletId;
    }

    public function setWalletId($walletId): self
    {
        $this->walletId = $walletId;
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

    public function getLedgerBalance()
    {
        return $this->ledgerBalance;
    }

    public function setLedgerBalance($ledgerBalance): self
    {
        $this->ledgerBalance = $ledgerBalance;
        return $this;
    }

    public function getWalletBalance()
    {
        return $this->walletBalance;
    }

    public function setWalletBalance($walletBalance): self
    {
        $this->walletBalance = $walletBalance;
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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
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

    public function selectQuery($isAll = false)
    {
        try {
            if ($isAll) {
                return BaseModel::query()->select($this->tableNames[0])
                    ->where("status = ?", [$this->status])
                    ->get();
            }
            return BaseModel::query()->select($this->tableNames[0])
                ->where("walletId = ? || userId = ?", [$this->walletId, $this->userId])
                ->first();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function insertQuery()
    {
        try {
            $insertData = array_filter([
                'walletId' => $this->walletId,
                'userId' => $this->userId,
                'ledger_balance' => $this->ledgerBalance,
                'wallet_balance' => $this->walletBalance,
                'status' => $this->status,
                'updatedAt' => $this->updatedAt,
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
            'ledger_balance' => $this->ledgerBalance,
            'wallet_balance' => $this->walletBalance,
            'status' => $this->status,
            'updatedAt' => $this->updatedAt,
        ]);

        if (empty($updateData)) {
            return false; // No data to update
        }

        try {
            return BaseModel::query()
                ->update(tableName: $this->tableNames[0], dataValues: $updateData)
                ->where("walletId = ? || userId = ?", [$this->walletId, $this->userId])
                ->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }

    public function deleteQuery()
    {
        try {
            return BaseModel::query()->delete($this->tableNames[0])
                   ->where("walletId = ? || userId = ?", [$this->walletId, $this->userId])->save();
        } catch (Exception $e) {
            Exceptions::exceptionHandler($e);
        }
    }
}
